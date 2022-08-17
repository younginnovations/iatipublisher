<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class RedirectResult
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }
}
