<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Dashboard\DashboardService;
use App\IATI\Services\Download\CsvGenerator;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * ActivityController Constructor.
     *
     * @param ActivityService $activityService
     * @param OrganizationService $organizationService
     * @param UserService $userService
     * @param DashboardService $dashboardService
     * @param CsvGenerator $csvGenerator
     */
    public function __construct(
        ActivityService $activityService,
        OrganizationService $organizationService,
        UserService $userService,
        DashboardService $dashboardService,
        CsvGenerator $csvGenerator
    ) {
        $this->dashboardService = $dashboardService;
        $this->csvGenerator = $csvGenerator;
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
     * Returns count of users registered today.
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredToday(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => "Today's user stats fetched successfully.",
                'data' => $this->dashboardService->getUsersRegisteredToday(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching the today's user count."]);
        }
    }

    /**
     * Returns count of users registered this week, grouped by day, formatted to named days [sunday, monday...].
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredThisWeek(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User count of this week fetched successfully.',
                'data' => $this->dashboardService->getUsersRegisteredThisWeek(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching this week's user count."]);
        }
    }

    /**
     * Returns count of users registered this week, grouped by days.
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredThisMonth(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User count of this month fetched successfully.',
                'data' => $this->dashboardService->getUsersRegisteredThisMonth(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching this month's user count."]);
        }
    }

    /**
     * Returns count of users registered this year, [Jan - today] grouped by month.
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredThisYear(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User count of this year fetched successfully.',
                'data' => $this->dashboardService->getUsersRegisteredThisYear(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching this year's user count."]);
        }
    }

    /**
     * Returns count of users registered in [{today - 7 days} to today], grouped by day.
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredLast7Days(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User count of last 7 days fetched successfully.',
                'data' => $this->dashboardService->getUsersRegisteredLast7Days(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching last 7 day's user count."]);
        }
    }

    /**
     * Returns count of users registered in [{current month - 6 months} to current month], grouped by month.
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredLast6Months(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User count of last 6 months fetched successfully',
                'data' => $this->dashboardService->getUsersRegisteredLast6Months(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching last 6 month's user count."]);
        }
    }

    /**
     * Returns count of users registered in [{current month - 12 months} to current month], grouped by month.
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredLast12Months(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'User count of last 12 months fetched successfully',
                'data' => $this->dashboardService->getUsersRegisteredLast12Months(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching last 12 month's user count."]);
        }
    }

    /**
     * Returns count of users registered in date range, grouped by nearest largest unit of time.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getDataInCustomRange(Request $request): JsonResponse
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $startDateString = Arr::get($queryParams, 'startDate', false);
            $endDateString = Arr::get($queryParams, 'endDate', false);

            if ($startDateString && $endDateString) {
                $carbon = new Carbon();
                $startDate = $carbon->parse($startDateString);
                $endDate = $carbon->parse($endDateString);
                $interval = $startDate->diff($carbon->parse($endDate));
                $intervalYear = $interval->y;
                $intervalMonth = $interval->m;

                $results = [];

                if ($intervalYear || $intervalMonth > 1) {
                    $unformattedResults = $this->dashboardService->getDataInRange($startDate, $endDate, 'months');
                    $results = $this->dashboardService->fillMissingMonthToData($startDate->startOfMonth(), $endDate->startOfMonth(), $unformattedResults);
                } else {
                    $unformattedResults = $this->dashboardService->getDataInRange($startDate, $endDate, 'days');
                    $results = $this->dashboardService->fillMissingDaysToData($startDate, $endDate, $unformattedResults);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'User count in date range fetched successfully',
                    'data' => $results,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid date range.',
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching user count in custom-range.']);
        }
    }

    /**
     * Download user report csv.
     *
     * @param Request $request
     * @param int $page
     *
     * @return BinaryFileResponse|JsonResponse
     */
    public function downloadUserReport(Request $request, int $page = 1): BinaryFileResponse|JsonResponse
    {
        try {
            $queryParams = $this->getQueryParams($request);
            $startDateString = Arr::get($queryParams, 'startDate', false);
            $endDateString = Arr::get($queryParams, 'endDate', false);

            if ($startDateString && $endDateString) {
                $carbon = new Carbon();
                $startDate = $carbon->parse($startDateString);
                $endDate = $carbon->parse($endDateString);
                $userData = $this->dashboardService->getUserDataForReportDownload($startDate, $endDate);
                $headers = ['Username', 'Organization', 'Email', 'Created Date', 'Last Logged in', 'Role', 'Status'];

                return $this->csvGenerator->generateWithHeaders(getTimeStampedText('users_report'), $userData, $headers);
            }

            return response()->json(['success' => false, 'message' => 'Invalid date range.']);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the paginated users.']);
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
