<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/verifyPublisher', [App\Http\Controllers\Api\Auth\RegisterController::class, 'verifyPublisher'])->name('verify-publisher');
Route::post('/register', [App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);

Route::get('/setting/data', [App\Http\Controllers\Api\Setting\SettingController::class, 'getSetting'])->name('setting.data');
Route::post('setting/store/publisher', [App\Http\Controllers\Api\Setting\SettingController::class, 'storePublishingInfo'])->name('setting.publisher.save');
Route::post('setting/store/default', [App\Http\Controllers\Api\Setting\SettingController::class, 'storeDefaultForm'])->name('setting.default.save');
Route::post('setting/verify', [App\Http\Controllers\Api\Setting\SettingController::class, 'verify'])->name('setting.verify');

Route::post('/reset', [App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'reset'])->name('reset');
