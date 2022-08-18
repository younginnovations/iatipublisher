<?php

namespace App\Http\Middleware;

use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\PeriodService;
use App\IATI\Services\Activity\ResultService;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

/**
 * Class RedirectActivity.
 */
class RedirectActivity
{
    /**
     * @var ActivityService
     */
    protected ActivityService $activityService;

    /**
     * @var ResultService
     */
    protected ResultService $resultService;

    /**
     * @var IndicatorService
     */
    protected IndicatorService $indicatorService;

    /**
     * @var PeriodService
     */
    private PeriodService $periodService;

    /**
     * @param ActivityService  $activityService
     * @param ResultService    $resultService
     * @param IndicatorService $indicatorService
     * @param PeriodService    $periodService
     */
    public function __construct(ActivityService $activityService, ResultService $resultService, IndicatorService $indicatorService, PeriodService $periodService)
    {
        $this->activityService = $activityService;
        $this->resultService = $resultService;
        $this->indicatorService = $indicatorService;
        $this->periodService = $periodService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $byPassActivityRoutes = [
            'admin.activities.index',
            'admin.activities.paginate',
            'admin.activities.codelist',
            'admin.activity.store',
        ];

        [$prefix, $module, $subModule] = explode('.', $request->route()->getName());

        if (in_array($request->route()->getName(), $byPassActivityRoutes, true)) {
            return $next($request);
        }

        $id = (int) $request->route('id');

        if (strlen($id) === strlen($request->route('id'))) {
            $activity = [];

            if ($module === 'activity') {
                $activity = $this->activityService->getActivity($id);

                if ($activity === null) {
                    return redirect(RouteServiceProvider::HOME);
                }

                if ($subModule === 'result') {
                    $byPassResultRoutes = ['admin.activity.result.index', 'admin.activity.results.paginate', 'admin.activity.result.create', 'admin.activity.result.store'];

                    if (!in_array($request->route()->getName(), $byPassResultRoutes, true)) {
                        $id = (int) $request->route('resultId');
                        $result = $this->resultService->getResult($id);

                        if ($result === null) {
                            return redirect(RouteServiceProvider::HOME)->with('error', 'Result does not exist');
                        }
                    }
                }
            } elseif ($module === 'result') {
                $result = $this->resultService->getResult($id);

                if ($result === null) {
                    return redirect(RouteServiceProvider::HOME);
                }

                if ($subModule === 'indicator') {
                    $byPassIndicatorRoutes = ['admin.result.indicator.index', 'admin.result.indicators.paginate', 'admin.result.indicator.create', 'admin.result.indicator.store'];

                    if (!in_array($request->route()->getName(), $byPassIndicatorRoutes, true)) {
                        $id = (int) $request->route($subModule);

                        if (empty($this->indicatorService->getIndicator($id))) {
                            return redirect(RouteServiceProvider::HOME)->with('error', 'Indicator does not exist');
                        }
                    }
                }
                $activity = $result->activity;
            } elseif ($module === 'indicator') {
                $indicator = $this->indicatorService->getIndicator($id);

                if ($indicator === null) {
                    return redirect(RouteServiceProvider::HOME);
                }

                if ($subModule === 'period') {
                    $byPassPeriodRoutes = ['admin.indicator.period.index', 'admin.indicator.periods.paginate', 'admin.indicator.period.create', 'admin.indicator.period.store'];

                    if (!in_array($request->route()->getName(), $byPassPeriodRoutes, true)) {
                        $id = (int) $request->route($subModule);
                        $period = $this->periodService->getPeriod($id);

                        if ($period === null) {
                            return redirect(RouteServiceProvider::HOME)->with('error', 'Period does not exist');
                        }
                    }
                }

                $activity = $indicator->result->activity;
            }

            if ($activity && !$activity->isActivityOfOrg()) {
                return redirect(RouteServiceProvider::HOME)->with('error', 'Activity does not exist');
            }

            return $next($request);
        }

        return abort(404);
    }
}
