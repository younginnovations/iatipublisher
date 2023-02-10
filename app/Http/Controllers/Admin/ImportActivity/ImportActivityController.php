<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\ImportActivity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\UploadActivity\ImportActivityRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\ImportActivity\ImportCsvService;
use App\IATI\Services\ImportActivity\ImportXmlService;
use App\IATI\Services\ImportActivityError\ImportActivityErrorService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
     * @var ImportActivityErrorService
     */
    protected ImportActivityErrorService $importActivityErrorService;

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $db;

    /**
     * @var string
     */
    public string $csv_data_storage_path;

    /**
     * @var string
     */
    public string $xml_data_storage_path;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService  $activityService
     * @param ImportCsvService $importCsvService
     * @param ImportXmlService $importXmlService
     * @param ImportActivityErrorService $importActivityErrorService
     * @param DatabaseManager  $db
     */
    public function __construct(ActivityService $activityService, ImportCsvService $importCsvService, ImportXmlService $importXmlService, ImportActivityErrorService $importActivityErrorService, DatabaseManager $db)
    {
        $this->activityService = $activityService;
        $this->importCsvService = $importCsvService;
        $this->importXmlService = $importXmlService;
        $this->importActivityErrorService = $importActivityErrorService;
        $this->db = $db;
        $this->csv_data_storage_path = env('CSV_DATA_STORAGE_PATH', 'CsvImporter/tmp');
        $this->xml_data_storage_path = env('XML_DATA_STORAGE_PATH', 'XmlImporter/tmp');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|JsonResponse|RedirectResponse
     */
    public function index(): View|JsonResponse|RedirectResponse
    {
        try {
            if (!Auth::user()->organization_id) {
                Session::put('error', 'User is not associated with any organization.');

                return redirect()->route('admin.activities.index');
            }

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
                if ($this->importXmlService->store($file)) {
                    $user = Auth::user();
                    $this->importXmlService->startImport($file->getClientOriginalName(), $user->id, $user->organization_id);
                }
            } else {
                if ($this->importCsvService->isCsvFileEmpty($file)) {
                    $response = ['success' => false, 'type' => 'danger', 'code' => ['message', ['message' => trans('Data not available')]], 'error' => trans('Data not available')];

                    return response()->json($response);
                }

                $this->importCsvService->clearOldImport();

                if ($this->importCsvService->storeCsv($file)) {
                    $filename = str_replace(' ', '', $file->getClientOriginalName());
                    $this->importCsvService->startImport($filename)
                        ->fireCsvUploadEvent($filename);
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

            Session::forget('import_filetype');
            Session::forget('error');
            Session::put('success', 'Imported data successfully.');

            return response()->json(['success' => true, 'message' => 'Imported successfully', 'type' => $filetype]);
        } catch (\Exception $e) {
            Session::put('error', 'Error occurred while importing activity');
            logger()->error($e->getMessage());
            logger()->error($e);

            return redirect()->back()->withResponse(['success' => false, 'message' => 'Error has occurred while importing activity.']);
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
            $filetype = Session::get('import_filetype');
            $orgId = Auth::user()->organization_id;

            if (!$orgId) {
                Session::put('error', 'User is not associated with any organization.');

                return redirect()->route('admin.activities.index');
            }

            if (!$filetype) {
                return redirect()->route('admin.activities.index');
            }

            $status = awsGetFile(sprintf('%s/%s/%s', $filetype === 'xml' ? $this->xml_data_storage_path : $this->csv_data_storage_path, $orgId, 'status.json'));
            $schema_error = awsGetFile(sprintf('%s/%s/%s', $filetype === 'xml' ? $this->xml_data_storage_path : $this->csv_data_storage_path, $orgId, 'schema_error.log'));

            if (!$status) {
                Session::put('error', 'status.json file not present in AWS');

                return redirect()->route('admin.activities.index');
            }

            $status = json_decode($status, true, 512, JSON_THROW_ON_ERROR);

            if ($schema_error) {
                Session::put('error', $status['message'] . '. To see errors <b>
                <a href=' . awsUrl(sprintf('%s/%s/%s', $filetype === 'xml' ? $this->xml_data_storage_path : $this->csv_data_storage_path, $orgId, 'schema_error.log')) . ' target="_blank">Open Error File</a></b>');

                return redirect()->route('admin.activities.index');
            }

            if (!$status['success']) {
                Session::put('error', $status['message']);

                return redirect()->route('admin.activities.index');
            }

            return view('admin.import.list');
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->withResponse(['success' => false, 'error' => 'Error has occurred while checking the status.']);
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

            if (!$filetype) {
                Session::put('error', 'Please upload csv or xml file to import activity.');

                return response()->json(['status' => 'error', 'message' => 'Please upload csv or xml file to import activity.']);
            }

            if ($filetype === 'xml') {
                $result = $this->importXmlService->loadJsonFile('status.json');
                $data = $this->importXmlService->loadJsonFile('valid.json');
            } else {
                $result = $this->importCsvService->getAwsCsvData('status.json');
                $data = $this->importCsvService->getAwsCsvData('valid.json');
            }

            $status = strcasecmp($result->message, 'Complete') === 0;

            if (!$data) {
                Session::put('error', 'Error has occurred while importing activities.');
            }

            return response()->json(['status' => $status, 'data' => $data]);
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
        $filepath = $this->importCsvService->getFilePath();
        $activities = [];

        if (file_exists($filepath)) {
            $activities = json_decode(file_get_contents($filepath), true, 512, JSON_THROW_ON_ERROR);
        }

        return $activities;
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

    /**
     * Delete upload error with activityId.
     *
     * @param mixed $activityId
     *
     * @return JsonResponse
     */
    public function deleteImportError($activityId): JsonResponse
    {
        try {
            $this->importActivityErrorService->deleteImportError($activityId);

            return response()->json(['success' => true, 'message' => 'Import error for activity has been successfully deleted.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while trying to delete import error.']);
        }
    }
}
