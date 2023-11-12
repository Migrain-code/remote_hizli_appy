<?php

Route::prefix('personal')->group(function () {
    Route::prefix('auth')->group(function (){
        Route::post('login', [\App\Http\Controllers\Api\PersonalAuthController::class, 'login']);
    });

    Route::middleware('auth:personal')->group(function () {
        Route::get('user', [\App\Http\Controllers\Api\PersonalAuthController::class, 'user']);
        Route::post('logout', [\App\Http\Controllers\Api\PersonalAuthController::class, 'logout']);
    });
});
