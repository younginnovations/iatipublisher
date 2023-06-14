<?php

use App\Http\Controllers\Admin\Download\DownloadActivityController;
use App\Http\Controllers\Admin\Download\DownloadCodesController;
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
Route::group(['middleware' => 'can:crud_activity'], static function () {
    Route::get('activities/download-csv', [DownloadActivityController::class, 'downloadActivityCsv'])->name('activities.download-csv');
    Route::get('activities/download-xml/{download?}', [DownloadActivityController::class, 'downloadActivityXml'])->name('activities.download-xml');
    Route::get('activities/download-codes/{download?}', [DownloadCodesController::class, 'downloadCodes'])->name('activities.download-codes');
    Route::get('activities/prepare-xls', [DownloadActivityController::class, 'prepareActivityXls'])->name('activities.prepare-xls');
    Route::get('activities/download-xls', [DownloadActivityController::class, 'downloadActivityXls'])->name('activities.download-xls');
    Route::get('/activities/download-xls-progress-status', [DownloadActivityController::class, 'xlsDownloadInProgressStatus'])->name('activities.xls.download-status');
    Route::get('/activities/cancel-xls-download', [DownloadActivityController::class, 'cancelXlsDownload'])->name('activities.xls.download-cancel');
    Route::get('/activities/retry-xls-download', [DownloadActivityController::class, 'retryXlsDownload'])->name('activities.xls.retry-xls-download');
});
