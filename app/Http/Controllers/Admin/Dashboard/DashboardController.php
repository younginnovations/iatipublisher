<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\IATI\Services\Audit\AuditService;
use App\IATI\Services\Dashboard\DashboardService;
use App\IATI\Services\Download\CsvGenerator;
use App\IATI\Services\User\UserService;
use Carbon\Exceptions\InvalidFormatException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * ActivityController Constructor.
     *
     * @param DashboardService $dashboardService
     * @param CsvGenerator $csvGenerator
     * @param AuditService $auditService
     */
    public function __construct(
        DashboardService $dashboardService,
        CsvGenerator $csvGenerator,
        AuditService $auditService
    ) {
        $this->dashboardService = $dashboardService;
        $this->csvGenerator = $csvGenerator;
        $this->auditService = $auditService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        return view('admin.dashboard.index');
    }

    /**
     * Returns user count for user dashboard.
     *
     * @return JsonResponse
     */
    public function getUserCounts(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User count fetched successfully',
                'data' => $this->dashboardService->getUserCounts(),
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    public function getUserCountByOrganization(Request $request, int $page = 1): JsonResponse
    {
        try {
            $queryParams = $this->getQueryParams($request);

            return response()->json([
                'success' => true,
                'message' => 'Paginated users fetched successfully',
                // 'data' => $this->userService->getUserCountByOrganization($page, $queryParams),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the paginated users.']);
        }
    }

    protected function getQueryParams($request): array
    {
        $validParameters = ['startDate', 'endDate'];
        $queryParams = [];

        foreach ($validParameters as $parameter) {
            $value = $request->get($parameter);

            if (!empty($value) || is_numeric($value)) {
                $queryParams[$parameter] = $value;
            }
        }

        return $queryParams;
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function publisherStats(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getPublisherStats($params);

            return response()->json([
                'success' => true,
                'message' => 'Publisher stats fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function publisherRegistrationCount(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getPublisherGroupedByDate($params, 'created_at');

            return response()->json([
                'success' => true,
                'message' => 'Publisher registration count fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function publisherRegistrationType(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getPublisherBy($params, 'registration_type');

            return response()->json([
                'success' => true,
                'message' => 'Publisher by type fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher by type.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function publisherGroupedByCountry(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getPublisherBy($params, 'country');
            $publisherStat['codelist'] = getCodeList('Country', 'Activity');

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by country fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function publisherGroupedByType(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getPublisherBy($params, 'publisher_type');
            $publisherStat['codelist'] = getCodeList('OrganizationType', 'Organization');

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by type fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher grouped by type.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function publisherGroupedByDataLicense(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getPublisherBy($params, 'data_license');
            $publisherStat['codelist'] = getCodeList('DataLicense', 'Activity');

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by type fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher grouped by type.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function publisherGroupedBySetupCompleteness(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getPublisherBySetup($params);

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by setup completeness fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function activityStats(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getActivityStats($params);

            return response()->json([
                'success' => true,
                'message' => 'Activity stats fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the activity stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function activityCount(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getActivityCount($params);

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by setup completeness fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function activityStatus(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getActivityStatus($params);

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by setup completeness fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param $request
     *
     * @return JsonResponse
     */
    public function activityMethod(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->dashboardService->getActivityBy($params, 'upload_medium');

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by setup completeness fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns json data containing publisher stats.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function activityCompleteness(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            // $publisherStat = $this->dashboardService->getActivityCompleteness($params);

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by setup completeness fetched successfully',
                // 'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns count of users registered in date range, grouped by nearest largest unit of time.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getDataInDateRange(Request $request): JsonResponse
    {
        try {
            list($fixedRangeString, $startDateString, $endDateString, $column) = $this->dashboardService->resolveDateRangeFromRequest($request);

            if (!$fixedRangeString && (!$startDateString || !$endDateString)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date range.',
                ]);
            }

            if ($fixedRangeString) {
                list($startDate, $endDate, $groupBy) = $this->dashboardService->resolveFixedRangeParams($fixedRangeString);
            } elseif ($startDateString && $endDateString) {
                list($startDate, $endDate, $groupBy) = $this->dashboardService->resolveCustomRangeParams($startDateString, $endDateString);
            }

            $unformattedResults = $this->dashboardService->getDataCountInRange($startDate, $endDate, $groupBy, $column);
            $results = $this->dashboardService->fillDataToMissingDates($startDate, $endDate, $unformattedResults);

            return response()->json([
                'success' => true,
                'message' => 'User count in date range fetched successfully',
                'data'    => $results,
            ]);
        } catch(InvalidFormatException $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Invalid date value entered in date range.']);
        } catch(\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching user count in custom-range.']);
        }
    }

    /**
     * Download user report csv.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadUserReport(Request $request): BinaryFileResponse|JsonResponse
    {
        try {
            list($fixedRangeString, $startDateString, $endDateString) = $this->dashboardService->resolveDateRangeFromRequest($request);

            if (!$fixedRangeString && (!$startDateString || !$endDateString)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid date range.',
                ]);
            }

            if ($fixedRangeString) {
                list($startDate, $endDate) = $this->dashboardService->resolveFixedRangeParams($fixedRangeString);
            } elseif ($startDateString && $endDateString) {
                list($startDate, $endDate) = $this->dashboardService->resolveCustomRangeParams($startDateString, $endDateString);
            }

            $userData = $this->dashboardService->getUserDataForReportDownload($startDate, $endDate);

            if (count($userData)) {
                $this->auditService->auditEvent($userData, 'download', 'csv');
                $headers = ['Username', 'Organization', 'Email', 'Created Date', 'Last Logged in', 'Role', 'Status'];

                return $this->csvGenerator->generateWithHeaders(getTimeStampedText('users_report'), $userData->toArray(), $headers);
            }

            return response()->json(['success'=>false, 'message'=>'No user data to download within this range']);
        } catch (InvalidFormatException $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Invalid date value entered in date range.']);
        } catch (\Exception $e) {
            logger()->error($e);

            return response()->json(['success' => false, 'message' => 'Error occurred while downloading user report.']);
        }
    }

    /*
     * Downloads selected activities in csv format.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadActivity(Request $request): BinaryFileResponse|JsonResponse
    {
        try {
            $headers = ['identifier', 'title', 'organization_name', 'status', 'medium', 'complete_percentage', 'created_at', 'updated_at'];

            $activities = $this->dashboardService->getAllActivitiesToDownload();

            // $this->auditService->auditEvent($activipublisherties, 'download', 'csv');

            return $this->csvGenerator->generateWithHeaders(getTimeStampedText('activities'), $activities, $headers);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            // $this->auditService->auditEvent(null, 'download', 'csv');

            return response()->json(['success' => false, 'message' => 'Error has occurred while downloading activity csv.']);
        }
    }

    /**
     * Download summary of organization in csv format.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadOrganization(Request $request): BinaryFileResponse|JsonResponse
    {
        try {
            $headers = ['organization', 'organization_name', 'publisher_id', 'country', 'status', 'medium', 'created_at', 'updated_at'];

            $organizations = $this->dashboardService->getOrganizationToDownload();

            // if (!isset($activities) || !count($activities)) {
            //     return response()->json(['success' => false, 'message' => 'No activities selected.']);
            // }

            // $this->auditService->auditEvent($activities, 'download', 'csv');

            return $this->csvGenerator->generateWithHeaders(getTimeStampedText('organizations'), $organizations, $headers);
        } catch (\Exception $e) {
            dd($e);
            logger()->error($e->getMessage());
            // $this->auditService->auditEvent(null, 'download', 'csv');

            return response()->json(['success' => false, 'message' => 'Error has occurred while downloading activity csv.']);
        }
    }
}
