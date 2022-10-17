<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Setting Routes
|--------------------------------------------------------------------------
|
| Here is where you can register setting routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/
Route::group([], static function () {
    Route::get('/setting', [App\Http\Controllers\Admin\Setting\SettingController::class, 'index'])->name('setting.index');
    Route::get('/setting/data', [App\Http\Controllers\Admin\Setting\SettingController::class, 'getSetting'])->name('setting.data');
    Route::post('setting/store/publisher', [App\Http\Controllers\Admin\Setting\SettingController::class, 'storePublishingInfo'])->name('setting.publisher.save');
    Route::post('setting/store/default', [App\Http\Controllers\Admin\Setting\SettingController::class, 'storeDefaultForm'])->name('setting.default.save');
    Route::post('setting/verify', [App\Http\Controllers\Admin\Setting\SettingController::class, 'verify'])->name('setting.verify');
    Route::get('/setting/status', [App\Http\Controllers\Admin\Setting\SettingController::class, 'getSettingStatus'])->name('setting.status');
});
