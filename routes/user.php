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
    Route::post('/user', [App\Http\Controllers\Admin\User\UserController::class, 'store'])->name('user.create');
    Route::patch('/user/{id}', [App\Http\Controllers\Admin\User\UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [App\Http\Controllers\Admin\User\UserController::class, 'delete'])->name('user.delete');
    Route::patch('/user/status/{id}', [App\Http\Controllers\Admin\User\UserController::class, 'toggleUserStatus'])->name('user.edit.status');
    Route::get('/users', [App\Http\Controllers\Admin\User\UserController::class, 'index'])->name('user.index');
    Route::get('/users/page/{page}', [App\Http\Controllers\Admin\User\UserController::class, 'getPaginatedUsers'])->name('user.list');
    Route::get('/profile', [App\Http\Controllers\Admin\User\UserController::class, 'showUserProfile'])->name('user.profile');
    Route::post('/update/password', [App\Http\Controllers\Admin\User\UserController::class, 'updatePassword'])->name('user.edit.password');
    Route::post('/update/profile', [App\Http\Controllers\Admin\User\UserController::class, 'updateProfile'])->name('user.edit.profile');
});
