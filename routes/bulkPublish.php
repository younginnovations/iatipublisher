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
Route::name('admin.')->group(function () {
    Route::get('activities/core-elements-completed', [\App\Http\Controllers\Admin\Workflow\BulkPublishingController::class, 'checkCoreElementsCompleted'])->name('activities.coreElementsCompleted');
    Route::post('activities/validate-activities', [\App\Http\Controllers\Admin\Workflow\BulkPublishingController::class, 'validateActivities'])->name('activities.validateActivities');
    Route::get('activities/start-bulk-publish', [\App\Http\Controllers\Admin\Workflow\BulkPublishingController::class, 'startBulkPublish'])->name('activities.startBulkPublish');
    Route::get('activities/bulk-publish-status', [\App\Http\Controllers\Admin\Workflow\BulkPublishingController::class, 'getBulkPublishStatus'])->name('activities.bulkPublishStatus');
});
