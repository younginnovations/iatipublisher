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

//Test Line
Route::get('/', [App\Http\Controllers\Web\WebController::class, 'index'])->name('web');

Route::get('/activities', function () {
    return view('web.activities');
});

Auth::routes();
