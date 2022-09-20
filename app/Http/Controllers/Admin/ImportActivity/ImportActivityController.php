<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\ImportActivity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\UploadActivity\ImportActivityRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\ImportActivity\ImportCsvService;
use App\IATI\Services\ImportActivity\ImportXmlService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

/**
 * Class ActivityController.
 */
class ImportActivityController extends Controller
{
    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var ImportCsvService
     */
    protected ImportCsvService $importCsvService;

    /**
     * @var ImportXmlService
     */
    protected ImportXmlService $importXmlService;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService    $activityService
     * @param ImportCsvService $importCsvService
     * @param ImportXmlService $importXmlService
     * @param DatabaseManager    $db
     */
    public function __construct(ActivityService $activityService, ImportCsvService $importCsvService, ImportXmlService $importXmlService, DatabaseManager $db)
    {
        $this->activityService = $activityService;
        $this->importCsvService = $importCsvService;
        $this->importXmlService = $importXmlService;
        $this->db = $db;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|JsonResponse
     */
    public function index(): View|JsonResponse
    {
        try {
            return view('admin.import.index');
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while rendering activity import page.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ImportActivityRequest $request
     *
     * @return JsonResponse
     */
    public function store(ImportActivityRequest $request): JsonResponse
    {
        try {
            $file = $request->file('activity');
            $filetype = $file->extension();
            Session::put('import_filetype', $filetype);

            if ($filetype === 'xml') {
                $this->fixPermission(storage_path('xmlImporter/tmp'));

                if ($this->importXmlService->store($file)) {
                    $user = Auth::user();
                    $this->importXmlService->startImport($file->getClientOriginalName(), $user->id, $user->organization_id);
                }
            } else {
                if ($this->importCsvService->isCsvFileEmpty($file)) {
                    $response = ['type' => 'danger', 'code' => ['message', ['message' => trans('Data not available')]]];

                    return response()->json($response);
                }

                $this->importCsvService->clearOldImport();

                if ($this->importCsvService->storeCsv($file)) {
                    $filename = str_replace(' ', '', $file->getClientOriginalName());
                    $this->importCsvService->startImport($filename)
                        ->fireCsvUploadEvent($filename);

                    $this->fixPermission(storage_path('csvImporter/tmp'));

                    if (!$this->importCsvService->isInUTF8Encoding($filename)) {
                        $response = ['success' => false, 'code' => ['encoding_error', ['message' => 'Something went wrong']]];

                        return response()->json($response);
                    }
                }
            }

            return response()->json(['success' => true, 'message' => 'Uploaded successfully', 'type' => $filetype]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while rendering activity import page.']);
        }
    }

    /**
     * Import validated activities into the database.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function importValidatedActivities(Request $request): mixed
    {
        try {
            $this->db->beginTransaction();
            $activities = $request->get('activities');
            $filetype = Session::get('import_filetype');

            if ($activities) {
                if ($filetype === 'xml') {
                    $this->importXmlService->create($activities);
                } else {
                    $this->importCsvService->create($activities);
                    $this->importCsvService->endImport();
                }
            }

            $this->db->commit();

            Session::put('success', 'Imported data successfully.');

            return response()->json(['success' => true, 'message' => 'Imported successfully', 'type' => $filetype]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->back()->withResponse(['success' => false, 'message' => 'Error has occured while importing activity.']);
        }
    }

    /**
     * Show the status page for the Csv Import process.
     *
     * @return Factory|\Illuminate\View\View
     */
    public function status(): View|RedirectResponse
    {
        try {
            // not required
            $data = null;

            return view('admin.import.list', compact('data'));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activity')->withResponse(['success' => false, 'message' => 'Error has occurred while checking the status.']);
        }
    }

    /**
     * Check Import Status.
     *
     * @return JsonResponse
     */
    public function checkStatus(): JsonResponse
    {
        try {
            $filetype = Session::get('import_filetype');

            if ($filetype === 'xml') {
                $result = $this->importXmlService->loadJsonFile('status.json');
                $data = $this->importXmlService->loadJsonFile('valid.json');
                $status = Arr::get($result, 'success');
            } else {
                $result = $this->importCsvService->importIsComplete() ?? 'Processing';
                $status = $result !== 'Processing';

                $data = $this->getValidData();
            }

            return response()->json(['status' => 'success', 'data' => $data, 'status' => $status]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Get the remaining valid data.
     *
     * @return array
     * @throws \JsonException
     */
    public function getValidData(): array
    {
        $filepath = $this->importCsvService->getFilePath(true);
        $activities = [];

        if (file_exists($filepath)) {
            $activities = json_decode(file_get_contents($filepath), true, 512, JSON_THROW_ON_ERROR);
        }

        return $activities;
    }

    /**
     * Fix file permission while on staging environment.
     *
     * @param $path
     *
     * @return void
     */
    protected function fixPermission($path): void
    {
        shell_exec(sprintf('chmod 777 -R %s', $path));
    }

    /**
     * Returns csv file import template.
     *
     * @return bool|JsonResponse|string
     */
    public function downloadTemplate(): bool|JsonResponse|string
    {
        try {
            return file_get_contents(app_path(sprintf('CsvImporter/Templates/%s/%s.csv', 'Activity', 'other_fields_transaction')));
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
