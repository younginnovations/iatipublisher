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
    // Route::resource('/organisation', \App\Http\Controllers\Admin\Organization\OrganizationController::class);
    Route::get('/organisation', [\App\Http\Controllers\Admin\Organization\OrganizationController::class, 'index'])->name('organisation.index');
    Route::get('organisation/name', [\App\Http\Controllers\Admin\Organization\NameController::class, 'edit'])->name('organisation.name.edit');
    Route::put('organisation/name', [\App\Http\Controllers\Admin\Organization\NameController::class, 'update'])->name('organisation.name.update');
    Route::get('organisation/organisation_identifier', [\App\Http\Controllers\Admin\Organization\OrganizationIdentifierController::class, 'edit'])->name('organisation.identifier.edit');
    Route::put('organisation/organisation_identifier', [\App\Http\Controllers\Admin\Organization\OrganizationIdentifierController::class, 'update'])->name('organisation.identifier.update');
    Route::get('organisation/reporting_org', [\App\Http\Controllers\Admin\Organization\ReportingOrgController::class, 'edit'])->name('organisation.reporting-org.edit');
    Route::put('organisation/reporting_org', [\App\Http\Controllers\Admin\Organization\ReportingOrgController::class, 'update'])->name('organisation.reporting-org.update');
    Route::get('organisation/total_budget', [\App\Http\Controllers\Admin\Organization\TotalBudgetController::class, 'edit'])->name('organisation.total-budget.edit');
    Route::put('organisation/total_budget', [\App\Http\Controllers\Admin\Organization\TotalBudgetController::class, 'update'])->name('organisation.total-budget.update');
    Route::get('organisation/recipient_org_budget', [\App\Http\Controllers\Admin\Organization\RecipientOrgBudgetController::class, 'edit'])->name('organisation.recipient-org-budget.edit');
    Route::put('organisation/recipient_org_budget', [\App\Http\Controllers\Admin\Organization\RecipientOrgBudgetController::class, 'update'])->name('organisation.recipient-org-budget.update');
    Route::get('organisation/recipient_region_budget', [\App\Http\Controllers\Admin\Organization\RecipientRegionBudgetController::class, 'edit'])->name('organisation.recipient-region-budget.edit');
    Route::put('organisation/recipient_region_budget', [\App\Http\Controllers\Admin\Organization\RecipientRegionBudgetController::class, 'update'])->name('organisation.recipient-region-budget.update');
    Route::get('organisation/recipient_country_budget', [\App\Http\Controllers\Admin\Organization\RecipientCountryBudgetController::class, 'edit'])->name('organisation.recipient-country-budget.edit');
    Route::put('organisation/recipient_country_budget', [\App\Http\Controllers\Admin\Organization\RecipientCountryBudgetController::class, 'update'])->name('organisation.recipient-country-budget.update');
    Route::get('organisation/total_expenditure', [\App\Http\Controllers\Admin\Organization\TotalExpenditureController::class, 'edit'])->name('organisation.total-expenditure.edit');
    Route::put('organisation/total_expenditure', [\App\Http\Controllers\Admin\Organization\TotalExpenditureController::class, 'update'])->name('organisation.total-expenditure.update');
    Route::get('organisation/document_link', [\App\Http\Controllers\Admin\Organization\DocumentLinkController::class, 'edit'])->name('organisation.document-link.edit');
    Route::put('organisation/document_link', [\App\Http\Controllers\Admin\Organization\DocumentLinkController::class, 'update'])->name('organisation.document-link.update');
});
