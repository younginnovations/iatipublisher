<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LogoutIfInactive
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(Request): (Response|RedirectResponse)  $next
     * @return Response| JsonResponse
     */
    public function handle(Request $request, Closure $next): Response| JsonResponse
    {
        if (!Auth::user()->status || Auth::user()->deleted_at) {
            Auth::logout();
        }

        return $next($request);
    }
}
