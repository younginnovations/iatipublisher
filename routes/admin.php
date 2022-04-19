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

Route::get('/dashboard', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index'])->name('dashboard');

Route::get('/setting', [App\Http\Controllers\Admin\Setting\SettingController::class, 'index'])->name('setting.index');
Route::get('/setting/data', [App\Http\Controllers\Admin\Setting\SettingController::class, 'getSetting'])->name('setting.data');
Route::post('/store/publisher', [App\Http\Controllers\Admin\Setting\SettingController::class, 'storePublishingInfo'])->name('setting.publisher.save');
Route::post('/store/default', [App\Http\Controllers\Admin\Setting\SettingController::class, 'storeDefaultForm'])->name('setting.default.save');
