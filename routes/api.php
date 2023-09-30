<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\SetupController;
use \App\Http\Controllers\Api\City\CityController;

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
    Route::controller(SetupController::class)->prefix('setup')->as('setup.')->group(function (){
        Route::get('/', 'get');
        Route::post('/update', 'update');
    });

});
