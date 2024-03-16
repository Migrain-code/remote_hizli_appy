<?php

Route::prefix('personel')->group(function () {
    Route::prefix('auth')->group(function (){
        Route::post('login', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'login']);
    });

    Route::middleware('auth:personel')->group(function () {
        Route::post('logout', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'logout']);
        /*------- Hesabım Apisi -----------*/
        Route::resource('profile', \App\Http\Controllers\PersonelAccount\Profile\PersonalProfileUpdateController::class)->only([
            'index', 'create', 'store'
        ]);


    });
});
