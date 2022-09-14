<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class SuperAdminMiddleware.
 */
class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (isSuperAdmin()) {
            return $next($request);
        }

        return redirect()->route('admin.activities.index')->with(
            'error',
            'You need to be superadmin to use this route.'
        );
    }
}
