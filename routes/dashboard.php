<?php

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

    // api for publisher data
    Route::get('/dashboard/publisher/type', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByType'])->name('dashboard');
    Route::get('/dashboard/publisher/stats', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherStats'])->name('dashboard');
    Route::get('/dashboard/publisher/data-license', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByDataLicense'])->name('dashboard');
    Route::get('/dashboard/publisher/country', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedByCountry'])->name('dashboard');
    Route::get('/dashboard/publisher/registration-type', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherType'])->name('dashboard');
    Route::get('/dashboard/publisher/setup', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherGroupedBySetupCompleteness'])->name('dashboard');
    Route::get('/dashboard/publisher/registration-count', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'publisherRegistrationCount'])->name('dashboard');
});
