<?php

use App\Http\Controllers\Admin\Activity\ActivityController;
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
    Route::resource('/activities', ActivityController::class);
    Route::get('/activities/{id}', function () {
        return view('admin.activity.activity-detail');
    });
    Route::get('/activities/{id}/title-form', function () {
        return view('admin.activity.activity-title-form');
    });
    Route::post('/activity/{page}', [App\Http\Controllers\Admin\Activity\ActivityController::class, 'getActivities'])->name('paginate');
    Route::post('/activity', [App\Http\Controllers\Admin\Activity\ActivityController::class, 'store'])->name('store');
    Route::get('/languages', [App\Http\Controllers\Admin\Activity\ActivityController::class, 'getLanguages'])->name('codelist');
});
