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

Route::get('/', [App\Http\Controllers\Web\WebController::class, 'index'])->name('web');
Route::get('/register', [App\Http\Controllers\Web\WebController::class, 'register'])->name('register');
Route::get('/login', [App\Http\Controllers\Web\WebController::class, 'index'])->name('index.login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
// Route::get('/verifyEmail', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/reset', function () {
    return view('web.reset');
});

Route::get('/reset_password', function () {
    return view('web.reset_password');
});

Route::get('/password_recovery', function () {
    return view('web.password_recovery');
});
