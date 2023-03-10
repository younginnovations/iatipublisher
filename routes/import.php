<?php

use App\Http\Controllers\Admin\ImportActivity\ImportActivityController;
use App\Http\Controllers\Admin\ImportActivity\ImportXlsController;
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
Route::group(['middleware' => ['can:crud_activity']], static function () {
    Route::get('/import', [ImportActivityController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportActivityController::class, 'store'])->name('import');
    Route::get('/import/list', [ImportActivityController::class, 'status'])->name('import.list');
    Route::get('/import/check_status', [ImportActivityController::class, 'checkStatus'])->name('import.check.status');
    Route::post('/import/activity', [ImportActivityController::class, 'importValidatedActivities'])->name('import.activity');
    Route::get('/import/download/csv', [ImportActivityController::class, 'downloadTemplate'])->name('import.template');
    Route::delete('/import/errors/{activityId}', [ImportActivityController::class, 'deleteImportError'])->name('import.delete.error');

    Route::get('/import/xls', [ImportXlsController::class, 'index'])->name('import.xls.index');
    Route::post('/import/xls', [ImportXlsController::class, 'store'])->name('import.xls');
    Route::get('/import/download/xls', [ImportActivityController::class, 'downloadXlsTemplate'])->name('import.template.xls');
});
