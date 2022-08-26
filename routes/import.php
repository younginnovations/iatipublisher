<?php

use App\Http\Controllers\Admin\ImportActivity\ImportActivityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Setting Routes
|--------------------------------------------------------------------------
|
| Here is where you can register setting routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/
Route::name('admin.')->group(function () {
    Route::get('/import', [ImportActivityController::class, 'index'])->name('import');
    Route::post('/import', [ImportActivityController::class, 'store'])->name('import');
    Route::get('/import/list', [ImportActivityController::class, 'status'])->name('import.list');
    // Route::get('/import/status', [ImportActivityController::class, 'status'])->name('import.status');
    Route::get('/import/check_status', [ImportActivityController::class, 'checkStatus'])->name('import.check.status');
    Route::post('/import/activity', [ImportActivityController::class, 'importValidatedActivities'])->name('import.activity');
});
