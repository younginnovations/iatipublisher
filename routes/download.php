<?php

use App\Http\Controllers\Admin\Download\DownloadActivityController;
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
Route::middleware('can:crud_activity')->group([], static function () {
    Route::get('activities/download-csv', [DownloadActivityController::class, 'downloadActivityCsv'])->name('activities.download-csv');
    Route::get('activities/download-xml/{download?}', [DownloadActivityController::class, 'downloadActivityXml'])->name('activities.download-xml');
});
