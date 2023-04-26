<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Dashboard\DashboardService;
use App\IATI\Services\Organization\OrganizationService;
use App\IATI\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPUnit\Exception;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    protected ActivityService $activityService;

    protected OrganizationService $organizationService;

    protected UserService $userService;
    protected DashboardService $dashboardService;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService $activityService
     * @param OrganizationService $organizationService
     * @param UserService $userService
     * @param DashboardService $dashboardService
     */
    public function __construct(
        ActivityService $activityService,
        OrganizationService $organizationService,
        UserService $userService,
        DashboardService $dashboardService
    ) {
        $this->activityService = $activityService;
        $this->organizationService = $organizationService;
        $this->userService = $userService;
        $this->dashboardService = $dashboardService;
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
        } catch(Exception $e) {
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
                'data' => $this->userService->getUserCountByOrganization($page, $queryParams),
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
            $publisherStat = $this->organizationService->getPublisherStats($params);

            return response()->json([
                'success' => true,
                'message' => 'Publisher stats fetched successfully',
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
    public function publisherRegistrationCount(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->organizationService->getPublisherGroupedByDate($params, 'created_at');

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
     * @param $request
     *
     * @return JsonResponse
     */
    public function publisherRegistrationType(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->organizationService->getPublisherBy($params, 'registration_type');

            return response()->json([
                'success' => true,
                'message' => 'Publisher stats fetched successfully',
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
    public function publisherGroupedByCountry(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->organizationService->getPublisherBy($params, 'country');

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
            $publisherStat = $this->organizationService->getPublisherBy($params, 'publisher_type');

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
    public function publisherGroupedBySetupCompleteness(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->organizationService->getPublisherBySetup($params);

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
    public function activityStats(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->activityService->getActivityStats($params);

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
    public function activityCount(Request $request): JsonResponse
    {
        try {
            $params = $this->getQueryParams($request);
            $publisherStat = $this->activityService->getActivityCount($params);

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
            $publisherStat = $this->activityService->getActivityStatus($params);

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
            $publisherStat = $this->activityService->getActivityMethod($params);

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
            $publisherStat = $this->activityService->getActivityCompleteness($params);

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by setup completeness fetched successfully',
                'data'    => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }

    /**
     * Returns count of users registered today.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getUsersRegisteredToday(Request $request): JsonResponse
    {
        try {
            $countOnly = $request->get('count_only', true);

            return response()->json([
                'success' => true,
                'message' => "Today's user stats fetched successfully",
                'data'    => $this->dashboardService->getUsersRegisteredToday($countOnly),
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
                'message' => "Today's user stats fetched successfully",
                'data'    => $this->dashboardService->getUsersRegisteredThisWeek(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching the today's user count."]);
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
                'message' => "Today's user stats fetched successfully",
                'data'    => $this->dashboardService->getUsersRegisteredThisMonth(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => "Error occurred while fetching the today's user count."]);
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
                'message' => "Today's user stats fetched successfully",
                'data'    => $this->dashboardService->getUsersRegisteredThisYear(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json($e->getMessage());
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
                'message' => "Today's user stats fetched successfully",
                'data'    => $this->dashboardService->getUsersRegisteredLast7Days(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json($e->getMessage());
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
                'message' => "Today's user stats fetched successfully",
                'data'    => $this->dashboardService->getUsersRegisteredLast6Months(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json($e->getMessage());
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
                'message' => "Today's user stats fetched successfully",
                'data'    => $this->dashboardService->getUsersRegisteredLast12Months(),
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json($e->getMessage());
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
            $startDate = $request->query('startDate') ?? false;
            $endDate = $request->query('endDate') ?? false;

            if ($startDate && $endDate) {
                return response()->json([
                    'success' => true,
                    'message' => "Today's user stats fetched successfully",
                    'data'    => $this->dashboardService->getDataInFreeRange(),
                ]);
            }
        } catch(\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json($e->getMessage());
        }
    }
}
