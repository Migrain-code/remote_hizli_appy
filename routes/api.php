<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\SetupController;
use \App\Http\Controllers\Api\City\CityController;
use \App\Http\Controllers\Api\OfficialCreditCardController;
use App\Http\Controllers\Api\PaymentController;
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

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('check-phone', [AuthController::class, 'register']);
    Route::post('verify', [AuthController::class, 'verify']);
    Route::middleware('auth:api')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
Route::prefix('city')->group(function (){
    Route::get('list', [CityController::class, 'index']);
    Route::post('get', [CityController::class, 'get']);
});
Route::middleware('auth:api')->group(function () {
    Route::controller(SetupController::class)->prefix('setup')->group(function (){
        Route::get('/get', 'get');
        Route::post('/update', 'update');
    });
    Route::controller(OfficialCreditCardController::class)->prefix('cart')->group(function (){
        Route::get('/', 'index');
        Route::post('/get', 'get');
        Route::post('/delete', 'delete');
        Route::post('/save', 'store');
        Route::post('/update', 'update');
    });
    Route::controller(PaymentController::class)->prefix('payment')->group(function (){
        Route::get('/', 'index');
        Route::post('/pay', 'pay');
    });
    Route::controller(\App\Http\Controllers\Api\DetailSetupController::class)->prefix('detail-setup')->group(function (){
        Route::get('/step-1/get', 'index');
        Route::post('/step-1/update', 'step1');

        /*Route::get('/step-2/get', 'index');
        Route::post('/step-2/update', 'step1');*/

        Route::post('update/logo', 'updateLogo');

    });

});
