<?php

use App\Http\Controllers\Admin\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group([], static function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user/stats', [DashboardController::class, 'getUserCounts'])->name('getUserCounts');
    Route::get('/dashboard/user', [DashboardController::class, 'getUserCountByOrganization'])->name('getUserCountByOrganization');
    Route::get('/dashboard/user/download', [DashboardController::class, 'downloadUserReport'])->name('downloadUserReport');
    Route::get('/dashboard/user/count', [DashboardController::class, 'getDataInDateRange'])->name('getDataInCustomRange');
    /*
     * Example
     * dashboard/user/date-range?fixed=this_year <- Valid params for fixed are :today, this_week, this_month, this_year , last_N_UNITS (example, last_7_days, last_7_month, last_2_years)
     * dashboard/user/date-range?start_date=2021-01-23&end_date=2023-02-03
     */

    // api for publisher data
    Route::get('/dashboard/publisher/publisher-type', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByType'])->name('dashboard.publisher.type');
    Route::get('/dashboard/publisher/stats', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherStats'])->name('dashboard.publisher.stats');
    Route::get('/dashboard/publisher/data-license', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByDataLicense'])->name('dashboard.publisher.license');
    Route::get('/dashboard/publisher/country', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByCountry'])->name('dashboard.publisher.country');
    Route::get('/dashboard/publisher/registration-type', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherRegistrationType'])->name('dashboard.publisher.registration');
    Route::get('/dashboard/publisher/setup', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedBySetupCompleteness'])->name('dashboard.publisher.setup');
    Route::get('/dashboard/publisher/count', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherRegistrationCount'])->name('dashboard.publisher.registration_count');
    Route::get('/dashboard/publisher/download', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'downloadOrganization'])->name('dashboard.publisher.download');

    Route::get('/dashboard/activity/stats', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityStats'])->name('dashboard.activity.stats');
    Route::get('/dashboard/activity/count', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityCount'])->name('dashboard.activity.count');
    Route::get('/dashboard/activity/status', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityStatus'])->name('dashboard.activity.status');
    Route::get('/dashboard/activity/method', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityMethod'])->name('dashboard.activity.method');
    Route::get('/dashboard/activity/completeness', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityCompleteness'])->name('dashboard.activity.completeness');
    Route::get('/dashboard/activity/download', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'downloadActivity'])->name('dashboard.activity.download');
});
