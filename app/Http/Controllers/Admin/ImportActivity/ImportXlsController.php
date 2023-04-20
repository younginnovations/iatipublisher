<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\ImportActivity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\UploadActivity\ImportXlsRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\ImportActivity\ImportXlsService;
use App\IATI\Services\ImportActivityError\ImportActivityErrorService;
use App\XlsImporter\Foundation\Mapper\Activity;
use App\XlsImporter\Foundation\Mapper\Indicator;
use App\XlsImporter\Foundation\Mapper\Period;
use App\XlsImporter\Foundation\Mapper\Result;
use Arr;
use Exception;
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
class ImportXlsController extends Controller
{
    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var ImportXlsService
     */
    protected ImportXlsService $importXlsService;

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
    public string $xls_data_storage_path;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService  $activityService
     * @param ImportXlsService $importXlsService
     * @param ImportActivityErrorService $importActivityErrorService
     * @param DatabaseManager  $db
     */
    public function __construct(ActivityService $activityService, ImportXlsService $importXlsService, ImportActivityErrorService $importActivityErrorService, DatabaseManager $db)
    {
        $this->activityService = $activityService;
        $this->importXlsService = $importXlsService;
        $this->importActivityErrorService = $importActivityErrorService;
        $this->db = $db;
        $this->xls_data_storage_path = env('XLS_DATA_STORAGE_PATH', 'XlsImporter/tmp');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View|JsonResponse|RedirectResponse
     */
    public function index(): View|JsonResponse|RedirectResponse
    {
        try {
            // dd(awsHasFile('XlsImporter/tmp/1/2/status.json'));
            // $elements = readElementJsonSchema();
            // $final = [];

            // foreach ($elements as $elementName => $content) {
            //     $attributes = $this->getAttributes(Arr::get($content, 'attributes', []));
            //     $subElements = $this->getSubElements(Arr::get($content, 'sub_elements', []));

            //     foreach ($subElements as $key => $value) {
            //         $attributes[$key] = $value;
            //     }

            //     $final[$elementName] = $attributes;
            // }

            // dd(json_encode($final));

            // $this->getLinearizedElement();

            // $data = getCodeList('Sect', 'Activity', false);
            $data = json_encode(getCodeList('SectorVocabulary', 'Activity'));
            // test
            file_put_contents(app_path() . '/XlsImporter/Templates/test.json', $data);
            // dd('stop');
            // $activityMapper = new Activity();
            // $activityMapper->map($data);
            // $org_id = Auth::user()->organization->id;
            // $xlsType = "indicator";
            // dd($this->importXlsService->dbIatiIdentifiers($org_id, $xlsType));

            // period

            // $data = file_get_contents(app_path() . '/XlsImporter/Templates/period.json');
            // $data = json_decode($data, true, 512, 0);
            // $periodMapper = new Period();
            // $periodMapper->map($data);

            // indicator

            // $data = file_get_contents(app_path() . '/XlsImporter/Templates/indicator.json');
            // $data = json_decode($data, true, 512, 0);
            // $indicatorMapper = new Indicator();
            // $indicatorMapper->map($data);
            // $data = file_get_contents(app_path('/XlsImporter/Templates/result.json'));
            // $data = json_decode($data, true, 512, 0);
            // $resultMapper = new Result();
            // $resultMapper->map($data);
            // dd('stop');
            // $test = \App\IATI\Models\Activity\Activity::where('id', 26)->first();
            // $test = \App\IATI\Models\Activity\Result::where('id', 26)->first();
            // dd($test->toArray());
            // dd(json_encode($test, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_OBJECT_AS_ARRAY|JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK, 512));
            // dd(json_encode(json_decode(json_encode($test), true, 512)));
            // file_put_contents(app_path() . '/XlsImporter/Templates/activity_test.json', json_encode($test->toArray()));
            // dd($test);

            //            $data = file_get_contents(app_path() . '/XlsImporter/Templates/period.json');
//            $periodMapper = new Period();
//            $periodMapper->map($data);

            // $periodMapper

            //            $resultData = file_get_contents(app_path('/XlsImporter/Templates/result.json'));
//            $resultMapper = new Result();
//            $resultMapper->map($resultData);

            if (!Auth::user()->organization_id) {
                Session::put('error', 'User is not associated with any organization.');

                return redirect()->route('admin.activities.index');
            }

            return view('admin.import.xls.index');
        } catch (Exception $e) {
            dd($e);
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'error' => 'Error has occurred while rendering activity import page.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ImportXlsRequest $request
     *
     * @return JsonResponse
     */
    public function store(ImportXlsRequest $request): JsonResponse
    {
        try {
            $file = $request->file('activity');
            $xlsType = $request->get('xlsType');

            if ($this->importXlsService->store($file)) {
                $user = Auth::user();
                $this->importXlsService->startImport($file->getClientOriginalName(), $user->id, $user->organization_id, $xlsType);
            }

            return response()->json(['success' => true, 'message' => 'Uploaded successfully']);
        } catch (Exception $e) {
            logger()->error($e);
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
            // $this->importXlsService->deleteImportStatus();
            $this->db->beginTransaction();
            $status = $this->importXlsService->getImportStatus();

            // dd($status);
            $xlsType = $status['template'];

            $activities = json_decode($request->query('activities'));

            if ($activities) {
                $this->importXlsService->create($activities, $xlsType);
            }

            // $this->importXlsService->deleteImportStatus();

            $this->db->commit();

            return response()->json(['success' => true, 'message' => 'Imported successfully']);
        } catch (Exception $e) {
            dd($e);
            Session::put('error', 'Error occurred while importing activity');
            logger()->error($e->getMessage());

            return redirect()->back()->withResponse(['success' => false, 'message' => 'Error has occurred while importing activity.']);
        }
    }

    public function checkImportInProgress(): JsonResponse
    {
        try {
            $status = $this->importXlsService->getImportStatus();

            return response()->json(['success' => true, 'message' => 'Import status accessed successfully', 'status' => $status]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occured while trying to check import status']);
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
            $status = $this->importXlsService->getImportStatus();
            // $filetype = Session::get('import_filetype');

            if (empty($status)) {
                Session::put('error', 'Please upload xls file to import activity.');

                return response()->json(['status' => 'error', 'message' => 'Please upload xls file to import activity.']);
            }

            $result = $this->importXlsService->getAwsXlsData('status.json');

            $status = strcasecmp($result->message, 'Complete') === 0;

            return response()->json(['success' => true, 'data' => $result]);
        } catch (Exception $e) {
            dd($e);
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
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while trying to delete import error.']);
        }
    }

    /**
     * Delete upload error with activityId.
     *
     * @param mixed $organizationId
     *
     * @return JsonResponse
     */
    public function deleteImportStatus(): JsonResponse
    {
        try {
            $this->importXlsService->deleteImportStatus();

            return response()->json(['success' => true, 'message' => 'Import status for organization has been successfully deleted.']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occurred while trying to delete import status.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return View|JsonResponse|RedirectResponse
     */
    public function show(): View|JsonResponse|RedirectResponse
    {
        try {
            $status = $this->importXlsService->getImportStatus();
            $importData = $this->importXlsService->getAwsXlsData('valid.json');

            return view(
                'admin.import.xls.list',
                compact('status', 'importData')
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while opening import listing page.');
        }
    }
}
