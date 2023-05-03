<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Organization\OrganizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    protected ActivityService $activityService;

    protected OrganizationService $organizationService;

    /**
     * ActivityController Constructor.
     *
     * @param ActivityService                  $activityService
     * @param OrganizationService              $organizationService
     */
    public function __construct(
        ActivityService $activityService,
        OrganizationService $organizationService
    ) {
        $this->activityService = $activityService;
        $this->organizationService = $organizationService;
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
            $publisherStat = $this->organizationService->getPublisherStats($params);

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
            $publisherStat = $this->organizationService->getPublisherBy($params, 'data');

            return response()->json([
                'success' => true,
                'message' => 'Publisher grouped by setup completeness fetched successfully',
                'data' => $publisherStat,
            ]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage());

            return response()->json(['success' => false, 'message' => 'Error occurred while fetching the publisher stats.']);
        }
    }
}
