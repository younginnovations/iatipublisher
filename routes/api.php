<?php

use App\Http\Controllers\Api\ActivityController;
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
Route::group(['middleware' => 'can:crud_activity'], static function () {
    Route::delete('activity/{id}/{element}', [ActivityController::class, 'deleteElement'])->name('activity.element.delete');
});
