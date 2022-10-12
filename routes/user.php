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
Route::group([], static function () {
    Route::get('/user/verification/status', [App\Http\Controllers\Admin\User\UserController::class, 'getUserVerificationStatus'])->name('user.verification.status');
    Route::post('/user/verification/email', [App\Http\Controllers\Admin\User\UserController::class, 'resendVerificationEmail'])->name('user.verification.email');
});
