<?php

use App\Http\Controllers\SuperAdmin\SuperAdminController;
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
Route::namespace('SuperAdmin')->name('superadmin.')->group(function () {
    Route::get('/list-organisations', [SuperAdminController::class, 'listOrganizations'])->name('listOrganizations');
    Route::get('/list-organisations/page/{page?}', [SuperAdminController::class, 'getPaginatedOrganizations'])->name('listOrganizations.paginate');
    Route::get('/proxy-organisation/{userId}', [SuperAdminController::class, 'proxyOrganization'])->name('proxyOrganization');
    Route::get('/switch-back', [SuperAdminController::class, 'switchBack'])->name('switchBack');
});
