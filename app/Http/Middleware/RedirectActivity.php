<?php

namespace App\Http\Middleware;

use App\IATI\Models\Activity\Activity;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $activity = $request->route('id') ? $request->route('id') : ($request->route('activity') ?? null);
        $activity = gettype($activity) == 'string' ? Activity::where('id', $activity)->first()->toArray : $activity;

        if ($activity && $activity['org_id'] !== Auth::user()->organization_id) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
