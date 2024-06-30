<?php

use App\Http\Controllers\Api\v1\EH\CicoController;
use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {

    Route::prefix('eh')->group(function () {
        Route::prefix('cico')->group(function () {
            Route::get('record', [CicoController::class,'record']);
            Route::post('check', [CicoController::class,'checkInOut']);
        });
    });

});
