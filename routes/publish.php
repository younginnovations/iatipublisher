<?php

use App\Http\Controllers\Admin\Workflow\ActivityWorkflowController;
use App\Http\Controllers\Admin\Workflow\BulkPublishingController;
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
    Route::get('activities/core-elements-completed', [BulkPublishingController::class, 'checkCoreElementsCompleted'])->name('activities.coreElementsCompleted');
    Route::post('activities/validate-activities', [BulkPublishingController::class, 'validateActivities'])->name('activities.validateActivities');
    Route::get('activities/start-bulk-publish', [BulkPublishingController::class, 'startBulkPublish'])->name('activities.startBulkPublish');
    Route::get('activities/bulk-publish-status', [BulkPublishingController::class, 'getBulkPublishStatus'])->name('activities.bulkPublishStatus');
    Route::get('activities/checks-for-activity-publish', [ActivityWorkflowController::class, 'checksForActivityPublish'])->name('activities.checks_for_publish');
    Route::get('activities/checks-for-activity-bulk-publish', [BulkPublishingController::class, 'checksForActivityBulkPublish'])->name('activities.checks_for_bulk_publish');
    Route::get('activities/cancel-bulk-publish', [BulkPublishingController::class, 'cancelBulkPublishing'])->name('activities.stopBulkPublish');
});
