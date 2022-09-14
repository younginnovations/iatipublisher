<?php

namespace App\Http\Middleware;

use App\IATI\Models\User\User;
use Closure;
use Illuminate\Http\Request;

/**
 * Class OrganizationUserMiddleware.
 */
class OrganizationUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!isSuperAdminRoute() && auth()->user()->role_id === User::SUPER_ADMIN_ID) {
            return redirect()->route('superadmin.listOrganizations');
        }

        return $next($request);
    }
}
