<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        return view('admin.dashboard.index');
    }
}
