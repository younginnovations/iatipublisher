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

    Route::get('/dashboard/user/user-count', [DashboardController::class, 'getUserCounts'])->name('getUserCounts');
    Route::get('/dashboard/user/paginated-organization-users/{page?}', [DashboardController::class, 'getUserCountByOrganization'])->name('getUserCountByOrganization');
    Route::get('/dashboard/user/registered-today', [DashboardController::class, 'getUsersRegisteredToday'])->name('getUsersRegisteredToday');
    Route::get('/dashboard/user/registered-this-week', [DashboardController::class, 'getUsersRegisteredThisWeek'])->name('getUsersRegisteredThisWeek');
    Route::get('/dashboard/user/registered-this-month', [DashboardController::class, 'getUsersRegisteredThisMonth'])->name('getUsersRegisteredThisMonth');
    Route::get('/dashboard/user/registered-this-year', [DashboardController::class, 'getUsersRegisteredThisYear'])->name('getUsersRegisteredThisYear');
    Route::get('/dashboard/user/registered-last-7-days', [DashboardController::class, 'getUsersRegisteredLast7Days'])->name('getUsersRegisteredLast7Days');
    Route::get('/dashboard/user/registered-last-6-months', [DashboardController::class, 'getUsersRegisteredLast6Months'])->name('getUsersRegisteredLast6Months');
    Route::get('/dashboard/user/registered-last-12-months', [DashboardController::class, 'getUsersRegisteredLast12Months'])->name('getUsersRegisteredLast12Months');
    Route::get('/dashboard/user/date-range', [DashboardController::class, 'getDataInCustomRange'])->name('getDataInCustomRange');
    Route::get('/dashboard/user/download-report', [DashboardController::class, 'downloadUserReport'])->name('downloadUserReport');

    // api for publisher data
    Route::get('/dashboard/publisher/type', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByType'])->name('dashboard.publisher.type');
    Route::get('/dashboard/publisher/stats', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherStats'])->name('dashboard.publisher.stats');
    Route::get('/dashboard/publisher/data-license', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByDataLicense'])->name('dashboard.publisher.license');
    Route::get('/dashboard/publisher/country', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByCountry'])->name('dashboard.publisher.country');
    Route::get('/dashboard/publisher/registration-type', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherType'])->name('dashboard.publisher.registration');
    Route::get('/dashboard/publisher/setup', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedBySetupCompleteness'])->name('dashboard.publisher.setup');
    Route::get('/dashboard/publisher/registration-count', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherRegistrationCount'])->name('dashboard.publisher.registration_count');
    Route::get('/dashboard/publisher/download', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'downloadOrganization'])->name('dashboard.publisher.download');

    Route::get('/dashboard/activity/stats', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityStats'])->name('dashboard.activity.stats');
    Route::get('/dashboard/activity/count', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityCount'])->name('dashboard.activity.count');
    Route::get('/dashboard/activity/status', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityStatus'])->name('dashboard.activity.status');
    Route::get('/dashboard/activity/method', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityMethod'])->name('dashboard.activitiy.method');
    Route::get('/dashboard/activity/completeness', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'activityCompleteness'])->name('dashboard.activity.completeness');
    Route::get('/dashboard/activity/download', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'downloadActivity'])->name('dashboard.activity.download');
});
