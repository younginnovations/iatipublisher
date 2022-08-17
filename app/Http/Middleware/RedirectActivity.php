<?php

namespace App\Http\Middleware;

use App\IATI\Models\Activity\Activity;
use App\IATI\Models\Activity\Indicator;
use App\IATI\Models\Activity\Period;
use App\IATI\Models\Activity\Result;
use App\IATI\Models\Activity\Transaction;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Indicator.
 */
class RedirectActivity
{
    public function handle(Request $request, Closure $next)
    {
        $activity = $request->route('id') ?: ($request->route('activity'));
        $activity = is_string($activity) && (int) $activity && (strlen((string) (int) $activity) === strlen($activity)) ? Activity::where('id', $activity)->first()?->toArray() : $activity;

        $parameters = $request->route()->parameters;
        $data_exists = $this->checkIfDataExists($parameters);

        if ((!$activity && ($request->route()->uri !== 'activities' && $request->route()->uri !== 'activity/page/{page?}' && $request->route()->uri !== 'activity/codelists')) || !$data_exists) {
            return abort(404);
        }

        if ($activity && $activity['org_id'] !== Auth::user()->organization_id) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }

    /**
     * Checks if data with id exists.
     *
     * @param $routeParams
     *
     * @return bool
     */
    public function checkIfDataExists($routeParams): bool
    {
        foreach ($routeParams as $type => $id) {
            $exists = false;

            if (intval($id) && (strlen(strval(intval($id))) === strlen($id))) {
                switch ($type) {
                    case 'activity':
                        $exists = true;
                        break;

                    case 'result':
                        $exists = (bool) Result::where('id', $id)->first();
                        break;

                    case 'indicator':
                        $exists = (bool) Indicator::where('id', $id)->first();
                        break;

                    case 'period':
                        $exists = (bool) Period::where('id', $id)->first();
                        break;

                    case 'transaction':
                        $exists = (bool) Transaction::where('id', $id)->first();
                        break;
                    default:
                        $exists = true;
                }
            }

            if (!$exists) {
                return false;
            }
        }

        return true;
    }
}
