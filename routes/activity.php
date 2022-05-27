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
    Route::resource('/activities', \App\Http\Controllers\Admin\Activity\ActivityController::class);
    Route::get('/activity/page/{page?}', [App\Http\Controllers\Admin\Activity\ActivityController::class, 'getActivities'])->name('paginate');
    Route::get('/activity/codelists', [App\Http\Controllers\Admin\Activity\ActivityController::class, 'getLanguagesOrganization'])->name('codelist');
    Route::get('activities/{id}/title', [\App\Http\Controllers\Admin\Activity\TitleController::class, 'edit'])->name('activities.title.edit');
    Route::put('activities/{id}/title', [\App\Http\Controllers\Admin\Activity\TitleController::class, 'update'])->name('activities.title.update');
    Route::get('activities/{id}/activity_status', [\App\Http\Controllers\Admin\Activity\StatusController::class, 'edit'])->name('activities.status.edit');
    Route::put('activities/{id}/activity_status', [\App\Http\Controllers\Admin\Activity\StatusController::class, 'update'])->name('activities.status.update');
    Route::get('activities/{id}/activity_scope', [\App\Http\Controllers\Admin\Activity\ScopeController::class, 'edit'])->name('activities.scope.edit');
    Route::put('activities/{id}/activity_scope', [\App\Http\Controllers\Admin\Activity\ScopeController::class, 'update'])->name('activities.scope.update');
    Route::get('activities/{id}/default_flow_type', [\App\Http\Controllers\Admin\Activity\DefaultFlowTypeController::class, 'edit'])->name('activities.default-flow-type.edit');
    Route::put('activities/{id}/default_flow_type', [\App\Http\Controllers\Admin\Activity\DefaultFlowTypeController::class, 'update'])->name('activities.default-flow-type.update');
    Route::get('activities/{id}/default_finance_type', [\App\Http\Controllers\Admin\Activity\DefaultFinanceTypeController::class, 'edit'])->name('activities.default-finance-type.edit');
    Route::put('activities/{id}/default_finance_type', [\App\Http\Controllers\Admin\Activity\DefaultFinanceTypeController::class, 'update'])->name('activities.default-finance-type.update');
    Route::get('activities/{id}/default_aid_type', [\App\Http\Controllers\Admin\Activity\DefaultAidTypeController::class, 'edit'])->name('activities.default-aid-type.edit');
    Route::put('activities/{id}/default_aid_type', [\App\Http\Controllers\Admin\Activity\DefaultAidTypeController::class, 'update'])->name('activities.default-aid-type.update');
    Route::get('activities/{id}/default_tied_status', [\App\Http\Controllers\Admin\Activity\DefaultTiedStatusController::class, 'edit'])->name('activities.default-tied-status.edit');
    Route::put('activities/{id}/default_tied_status', [\App\Http\Controllers\Admin\Activity\DefaultTiedStatusController::class, 'update'])->name('activities.default-tied-status.update');
    Route::get('activities/{id}/collaboration_type', [\App\Http\Controllers\Admin\Activity\CollaborationTypeController::class, 'edit'])->name('activities.collaboration-type.edit');
    Route::put('activities/{id}/collaboration_type', [\App\Http\Controllers\Admin\Activity\CollaborationTypeController::class, 'update'])->name('activities.collaboration-type.update');
    Route::get('activities/{id}/capital_spend', [\App\Http\Controllers\Admin\Activity\CapitalSpendController::class, 'edit'])->name('activities.capital-spend.edit');
    Route::put('activities/{id}/capital_spend', [\App\Http\Controllers\Admin\Activity\CapitalSpendController::class, 'update'])->name('activities.capital-spend.update');
    Route::get('activities/{id}/related_activity', [\App\Http\Controllers\Admin\Activity\RelatedActivityController::class, 'edit'])->name('activities.related-activity.edit');
    Route::put('activities/{id}/related_activity', [\App\Http\Controllers\Admin\Activity\RelatedActivityController::class, 'update'])->name('activities.related-activity.update');
});
