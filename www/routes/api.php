<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EidEasyController;
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
Route::group(['prefix' => 'eid-easy'], function () {
    Route::get('/verify-user', [EidEasyController::class, 'verifyUser']);
    Route::post('/fetch-user', [EidEasyController::class, 'fetchUser']);
});