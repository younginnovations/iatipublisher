<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\ImportActivity;

use App\Helpers\ImportCacheHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\UploadActivity\ImportXlsRequest;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\ImportActivity\ImportStatusService;
use App\IATI\Services\ImportActivity\ImportXlsService;
use App\IATI\Services\ImportActivityError\ImportActivityErrorService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * @var ImportStatusService
     */
    private ImportStatusService $importStatusService;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService                                       $activityService
     * @param ImportXlsService                                      $importXlsService
     * @param ImportActivityErrorService                            $importActivityErrorService
     * @param DatabaseManager                                       $db
     * @param ImportStatusService $importStatusService
     */
    public function __construct(ActivityService $activityService, ImportXlsService $importXlsService, ImportActivityErrorService $importActivityErrorService, DatabaseManager $db, ImportStatusService $importStatusService)
    {
        $this->activityService = $activityService;
        $this->importXlsService = $importXlsService;
        $this->importActivityErrorService = $importActivityErrorService;
        $this->importStatusService = $importStatusService;
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
            if (!Auth::user()->organization_id) {
                Session::put('error', 'User is not associated with any organization.');

                return redirect()->route('admin.activities.index');
            }

            return view('admin.import.xls.index');
        } catch (Exception $e) {
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
            $status = $this->importXlsService->getImportStatus();
            $orgId = Auth::user()->organization_id;
            $ongoingImportStatus = $this->importStatusService->getOrganisationImportStatus($orgId);

            if (ImportCacheHelper::hasOngoingImport($orgId) || !empty($status) || Arr::get($ongoingImportStatus, 'status') === 'processing') {
                return response()->json([
                    'success' => false,
                    'message' => 'Import is currently on progress. Please cancel the current import to continue.',
                    'data'    => [
                        'has_ongoing_import' => true,
                        'import_type'        => Arr::get($ongoingImportStatus, 'type', 'xls'),
                    ],
                ]);
            }

            if ($this->importXlsService->store($file)) {
                $user = Auth::user();
                $this->importXlsService->startImport($file->getClientOriginalName(), $user->id, $user->organization_id, $xlsType);
            }

            ImportCacheHelper::setImportStepToValidating($orgId);

            return response()->json(['success' => true, 'message' => 'Uploaded successfully']);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            ImportCacheHelper::clearImportCache(Auth::user()->organization_id);

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
            $status = $this->importXlsService->getImportStatus();
            $activities = $request->get('activities');

            if (empty($status)) {
                return response()->json(['success' => false, 'message' => 'Please ensure that you have uploaded xls file.']);
            }

            if (empty($activities)) {
                return response()->json(['success' => false, 'message' => 'Please select the data you want to add.']);
            }

            $xlsType = $status['template'];

            if ($xlsType === 'activity' && !ImportCacheHelper::organisationHasCompletedValidatingData(Auth::user()->organization_id)) {
                return response()->json(['success' => false, 'message' => 'Error has occurred while importing the data.', 'type' => $xlsType]);
            }

            $this->importXlsService->create($activities, $xlsType);
            $this->importXlsService->deleteImportStatus();
            $this->db->commit();

            ImportCacheHelper::clearImportCache(Auth::user()->organization_id);

            Session::put('success', "Xls file with $xlsType imported successfully.");

            return response()->json(['success' => true, 'message' => "Xls file with $xlsType imported successfully."]);
        } catch (Exception $e) {
            Session::put('error', 'Error occurred while importing activity');

            ImportCacheHelper::clearImportCache(Auth::user()->organization_id);

            logger()->error($e);

            return redirect()->back()->withResponse(['success' => false, 'message' => 'Error has occurred while importing activity.']);
        }
    }

    /**
     * Checks if import progress data is present for user in database.
     *
     * @return JsonResponse
     */
    public function checkImportInProgressForPolling(): JsonResponse
    {
        try {
            $status = $this->importXlsService->getImportStatus();

            if (isset($status['status']) && $status['status'] === 'failed') {
                $result = $this->importXlsService->getAwsXlsData('status.json');
                $status['message'] = $result->message;
            }

            return response()->json(['success' => true, 'message' => 'Import status accessed successfully', 'status' => $status]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error has occured while trying to check import status']);
        }
    }

    /**
     * Check Import Status based on status.json file present at AWS.
     *
     * @return JsonResponse
     */
    public function checkStatus(): JsonResponse
    {
        try {
            $status = $this->importXlsService->getImportStatus();

            if (empty($status)) {
                return response()->json(['status' => 'error', 'message' => 'Please upload xls file to import activity.']);
            }

            $result = $this->importXlsService->getAwsXlsData('status.json');

            $status = strcasecmp($result->message, 'Complete') === 0;

            return response()->json(['success' => true, 'data' => $result]);
        } catch (Exception $e) {
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
            DB::beginTransaction();

            $this->importXlsService->deleteImportStatus();
            $this->importStatusService->deleteOngoingImports(Auth::user()->organization_id);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Import status for organization has been successfully deleted.']);
        } catch (Exception $e) {
            DB::rollBack();
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

            if (empty($status)) {
                return redirect()->route('admin.activities.index')->with('error', 'Please upload xls file to continue.');
            }

            $importData = $this->importXlsService->getAwsXlsData('valid.json');
            $globalError = $this->importXlsService->getAwsXlsData('globalError.json');
            $errors = $globalError->errors;
            $errors = empty($errors) ? null : $errors;
            $errorCount = $globalError->error_count;

            return view(
                'admin.import.xls.list',
                compact('status', 'importData', 'errors', 'errorCount')
            );
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return redirect()->route('admin.activities.index')->with('error', 'Error has occurred while opening import listing page.');
        }
    }
}
