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
    Route::post('/activity/{page}', [App\Http\Controllers\Api\Activity\ActivityController::class, 'getActivities'])->name('paginate');
});
