<?php

use App\Http\Controllers\Audit\AuditController;
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
Route::group([], function () {
    Route::get('/audit', [AuditController::class, 'index'])->name('index');
    Route::get('/audit/page/{page}', [AuditController::class, 'getAuditLog'])->name('list');
});
