<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\IATI\Models\User\Role;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class OrganizationUserMiddleware.
 */
class OrganizationUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request                                         $request
     * @param  \Closure(Request): (Response|RedirectResponse) $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!isSuperAdminRoute() && auth()->user()->role_id === app(Role::class)->getSuperAdminId()) {
            return redirect()->route('superadmin.listOrganizations');
        }

        return $next($request);
    }
}
