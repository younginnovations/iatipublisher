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
Route::group(['middleware'=>'superadmin'], static function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user/download', [DashboardController::class, 'downloadUserReport'])->name('downloadUserReport');
    Route::get('/dashboard/user/stats', [DashboardController::class, 'getUserCounts'])->name('getUserCounts');
    Route::get('/dashboard/user', [DashboardController::class, 'getUserCountByOrganization'])->name('getUserCountByOrganization');
    Route::get('/dashboard/user/count', [DashboardController::class, 'getDataInDateRange'])->name('getDataInCustomRange');

    // api for publisher data
    Route::get('/dashboard/publisher/download', [DashboardController::class, 'downloadOrganization'])->name('dashboard.publisher.download');
    Route::get('/dashboard/publisher/stats', [DashboardController::class, 'publisherStats'])->name('dashboard.publisher.stats');
    Route::get('/dashboard/publisher/publisher-type', [DashboardController::class, 'publisherGroupedByType'])->name('dashboard.publisher.type');
    Route::get('/dashboard/publisher/data-license', [DashboardController::class, 'publisherGroupedByDataLicense'])->name('dashboard.publisher.license');
    Route::get('/dashboard/publisher/country', [DashboardController::class, 'publisherGroupedByCountry'])->name('dashboard.publisher.country');
    Route::get('/dashboard/publisher/registration-type', [DashboardController::class, 'publisherRegistrationType'])->name('dashboard.publisher.registration');
    Route::get('/dashboard/publisher/setup', [DashboardController::class, 'publisherGroupedBySetupCompleteness'])->name('dashboard.publisher.setup');
    Route::get('/dashboard/publisher/count', [DashboardController::class, 'publisherRegistrationCount'])->name('dashboard.publisher.registration_count');

    Route::get('/dashboard/activity/download', [DashboardController::class, 'downloadActivity'])->name('dashboard.activity.download');
    Route::get('/dashboard/activity/stats', [DashboardController::class, 'activityStats'])->name('dashboard.activity.stats');
    Route::get('/dashboard/activity/status', [DashboardController::class, 'activityStatus'])->name('dashboard.activity.status');
    Route::get('/dashboard/activity/method', [DashboardController::class, 'activityMethod'])->name('dashboard.activity.method');
    Route::get('/dashboard/activity/completeness', [DashboardController::class, 'activityCompleteness'])->name('dashboard.activity.completeness');
    Route::get('/dashboard/activity/count', [DashboardController::class, 'activityCount'])->name('dashboard.activity.count');
});
