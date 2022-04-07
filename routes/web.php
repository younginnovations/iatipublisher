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

Route::get('/', [App\Http\Controllers\Web\WebController::class, 'index'])->name('web');
Route::get('/register', [App\Http\Controllers\Web\WebController::class, 'register'])->name('register');

Route::get('/activities', function () {
    return view('web.activities');
});

// Auth::routes();

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/verifyPublisher', [App\Http\Controllers\Auth\RegisterController::class, 'verifyPublisher'])->name('verify-publisher');
// Route::post('/verifyPublisher', [App\Http\Controllers\Auth\RegisterController::class, 'verifyPublisher'])->name('verify-publisher');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/verifyEmail', [App\Http\Controllers\Web\WebController::class, 'index'])->name('verification.verify');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
