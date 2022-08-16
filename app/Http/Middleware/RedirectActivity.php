<?php

namespace App\Http\Middleware;

use App\IATI\Services\Activity\ActivityService;
use App\IATI\Services\Activity\IndicatorService;
use App\IATI\Services\Activity\ResultService;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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

    public function __construct(ActivityService $activityService, ResultService $resultService, IndicatorService $indicatorService)
    {
        $this->activityService = $activityService;
        $this->resultService = $resultService;
        $this->indicatorService = $indicatorService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request                                        $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $id = (int) $request->route('id');

        if (strlen($id) === strlen($request->route('id'))) {
            $module = explode('.', $request->route()->getName())[1];
            $activity = [];

            if ($module === 'activity') {
                $activity = $this->activityService->getActivity($id);
            } elseif ($module === 'result') {
                $result = $this->resultService->getResult($id);
                $activity = $result->activity;
                dd($activity);
            } elseif ($module === 'indicator') {
                $indicator = $this->indicatorService->getIndicator($id);
                $activity = $indicator->result->activity;
            }

            if ($activity && $activity['org_id'] !== Auth::user()->organization_id) {
                return redirect(RouteServiceProvider::HOME);
            }

            return $next($request);
        }

        return abort(404);
    }
}
