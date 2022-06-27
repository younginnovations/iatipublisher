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
    Route::get('activities/{id}/legacy_data', [\App\Http\Controllers\Admin\Activity\LegacyDataController::class, 'edit'])->name('activities.legacy-data.edit');
    Route::put('activities/{id}/legacy_data', [\App\Http\Controllers\Admin\Activity\LegacyDataController::class, 'update'])->name('activities.legacy-data.update');
    Route::get('activities/{id}/description', [\App\Http\Controllers\Admin\Activity\DescriptionController::class, 'edit'])->name('activities.description.edit');
    Route::put('activities/{id}/description', [\App\Http\Controllers\Admin\Activity\DescriptionController::class, 'update'])->name('activities.description.update');
    Route::get('activities/{id}/activity_date', [\App\Http\Controllers\Admin\Activity\DateController::class, 'edit'])->name('activities.date.edit');
    Route::put('activities/{id}/activity_date', [\App\Http\Controllers\Admin\Activity\DateController::class, 'update'])->name('activities.date.update');
    Route::get('activities/{id}/recipient_country', [\App\Http\Controllers\Admin\Activity\RecipientCountryController::class, 'edit'])->name('activities.recipient-country.edit');
    Route::put('activities/{id}/recipient_country', [\App\Http\Controllers\Admin\Activity\RecipientCountryController::class, 'update'])->name('activities.recipient-country.update');
    Route::get('activities/{id}/humanitarian_scope', [\App\Http\Controllers\Admin\Activity\HumanitarianScopeController::class, 'edit'])->name('activities.humanitarian-scope.edit');
    Route::put('activities/{id}/humanitarian_scope', [\App\Http\Controllers\Admin\Activity\HumanitarianScopeController::class, 'update'])->name('activities.humanitarian-scope.update');
    Route::get('activities/{id}/sector', [\App\Http\Controllers\Admin\Activity\SectorController::class, 'edit'])->name('activities.sector.edit');
    Route::put('activities/{id}/sector', [\App\Http\Controllers\Admin\Activity\SectorController::class, 'update'])->name('activities.sector.update');
    Route::get('activities/{id}/conditions', [\App\Http\Controllers\Admin\Activity\ConditionController::class, 'edit'])->name('activities.conditions.edit');
    Route::put('activities/{id}/conditions', [\App\Http\Controllers\Admin\Activity\ConditionController::class, 'update'])->name('activities.conditions.update');
    Route::get('activities/{id}/country_budget_items', [\App\Http\Controllers\Admin\Activity\CountryBudgetItemController::class, 'edit'])->name('activities.country-budget-items.edit');
    Route::put('activities/{id}/country_budget_items', [\App\Http\Controllers\Admin\Activity\CountryBudgetItemController::class, 'update'])->name('activities.country-budget-items.update');
    Route::get('activities/{id}/default_aid_type', [\App\Http\Controllers\Admin\Activity\DefaultAidTypeController::class, 'edit'])->name('activities.default-aid-type.edit');
    Route::put('activities/{id}/default_aid_type', [\App\Http\Controllers\Admin\Activity\DefaultAidTypeController::class, 'update'])->name('activities.default-aid-type.update');
    Route::get('activities/{id}/policy_marker', [\App\Http\Controllers\Admin\Activity\PolicyMarkerController::class, 'edit'])->name('activities.policy-marker.edit');
    Route::put('activities/{id}/policy_marker', [\App\Http\Controllers\Admin\Activity\PolicyMarkerController::class, 'update'])->name('activities.policy-marker.update');
    Route::get('activities/{id}/recipient_region', [\App\Http\Controllers\Admin\Activity\RecipientRegionController::class, 'edit'])->name('activities.recipient-region.edit');
    Route::put('activities/{id}/recipient_region', [\App\Http\Controllers\Admin\Activity\RecipientRegionController::class, 'update'])->name('activities.recipient-region.update');
    Route::get('activities/{id}/tag', [\App\Http\Controllers\Admin\Activity\TagController::class, 'edit'])->name('activities.tag.edit');
    Route::put('activities/{id}/tag', [\App\Http\Controllers\Admin\Activity\TagController::class, 'update'])->name('activities.tag.update');
    Route::get('activities/{id}/other_identifier', [\App\Http\Controllers\Admin\Activity\OtherIdentifierController::class, 'edit'])->name('activities.other-identifier.edit');
    Route::put('activities/{id}/other_identifier', [\App\Http\Controllers\Admin\Activity\OtherIdentifierController::class, 'update'])->name('activities.other-identifier.update');
    Route::get('activities/{id}/iati_identifier', [\App\Http\Controllers\Admin\Activity\IdentifierController::class, 'edit'])->name('activities.identifier.edit');
    Route::get('activities/{id}/identifier', [\App\Http\Controllers\Admin\Activity\IdentifierController::class, 'edit'])->name('activities.identifier.edit');
    Route::put('activities/{id}/iati_identifier', [\App\Http\Controllers\Admin\Activity\IdentifierController::class, 'update'])->name('activities.identifier.update');
    Route::get('activities/{id}/document_link', [\App\Http\Controllers\Admin\Activity\DocumentLinkController::class, 'edit'])->name('activities.document-link.edit');
    Route::put('activities/{id}/document_link', [\App\Http\Controllers\Admin\Activity\DocumentLinkController::class, 'update'])->name('activities.document-link.update');
    Route::get('activities/{id}/contact_info', [\App\Http\Controllers\Admin\Activity\ContactInfoController::class, 'edit'])->name('activities.contact-info.edit');
    Route::put('activities/{id}/contact_info', [\App\Http\Controllers\Admin\Activity\ContactInfoController::class, 'update'])->name('activities.contact-info.update');
    Route::get('activities/{id}/location', [\App\Http\Controllers\Admin\Activity\LocationController::class, 'edit'])->name('activities.location.edit');
    Route::put('activities/{id}/location', [\App\Http\Controllers\Admin\Activity\LocationController::class, 'update'])->name('activities.location.update');
    Route::get('activities/{id}/participating_org', [\App\Http\Controllers\Admin\Activity\ParticipatingOrganizationController::class, 'edit'])->name('activities.participating-org.edit');
    Route::put('activities/{id}/participating_org', [\App\Http\Controllers\Admin\Activity\ParticipatingOrganizationController::class, 'update'])->name('activities.participating-org.update');
    Route::get('activities/{id}/planned_disbursement', [\App\Http\Controllers\Admin\Activity\PlannedDisbursementController::class, 'edit'])->name('activities.planned-disbursement.edit');
    Route::put('activities/{id}/planned_disbursement', [\App\Http\Controllers\Admin\Activity\PlannedDisbursementController::class, 'update'])->name('activities.planned-disbursement.update');
    Route::get('activities/{id}/budget', [\App\Http\Controllers\Admin\Activity\BudgetController::class, 'edit'])->name('activities.budget.edit');
    Route::put('activities/{id}/budget', [\App\Http\Controllers\Admin\Activity\BudgetController::class, 'update'])->name('activities.budget.update');

    Route::resource('activities.results', \App\Http\Controllers\Admin\Activity\ResultController::class);
});
