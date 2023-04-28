<?php

use App\Http\Controllers\ApiLog\ApiLogController;
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
Route::group(['namespace' => 'SuperAdmin', 'middleware' => ['can:list_organizations', 'can:proxy_user']], function () {
    Route::get('/list-organisations', [SuperAdminController::class, 'listOrganizations'])->name('listOrganizations');
    Route::get('/list-organisations/page/{page?}', [SuperAdminController::class, 'getPaginatedOrganizations'])->name('listOrganizations.paginate');
    Route::get('/proxy-organisation/{userId}', [SuperAdminController::class, 'proxyOrganization'])->name('proxyOrganization');
    Route::get('/system-version', [SuperAdminController::class, 'listSystemVersion'])->name('systemVersion');
    Route::get('/api-log', [ApiLogController::class, 'getData'])->name('getData');
});

//
//[
//"today" => 'start date and end date is today'
//"this-week" => 'end date is today and start day is within this week (sun - sat)'
//"last-7-days" => 'end date is today and start day is today minus 7days'
//"this-month" => 'start month and end month is current month '
//"last-6-months" => 'end month is current and start month is current minus 6 months'
//"this-year" => 'end year is current year and start year is current year as well '
//"all-time" => 'any date besides above is all time'
//]
