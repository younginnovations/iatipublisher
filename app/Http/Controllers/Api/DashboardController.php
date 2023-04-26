<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

/*
 * Class DashboardController.
 */

use App\IATI\Services\User\UserService;

class DashboardController
{
    public function __construct(protected UserService $userService)
    {
    }
}
