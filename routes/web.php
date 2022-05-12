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

Auth::routes(['verify' => true]);

Route::name('web.')->group(function () {
    Route::get('/', [App\Http\Controllers\Web\WebController::class, 'index']);
    Route::get('/register/{page}', [App\Http\Controllers\Web\WebController::class, 'index'])->name('join');
    Route::get('/register', [App\Http\Controllers\Web\WebController::class, 'register'])->name('register');
    Route::get('/login', [App\Http\Controllers\Web\WebController::class, 'index'])->name('index.login');
});

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/verifyPublisher', [App\Http\Controllers\Auth\RegisterController::class, 'verifyPublisher'])->name('verify-publisher');
// Route::get('/verifyEmail', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.email');
Route::get('/password/confirm', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showEmailSentMessage'])->name('password.confirm');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('reset');
