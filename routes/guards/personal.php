<?php
//Personel Apileri
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
        /*------Bildirim İzinleri- --------*/
        Route::resource('notification-permission', \App\Http\Controllers\PersonelAccount\Notification\PersonelNotificationPermissionController::class)->only([
            'index', 'store'
        ]);
        /*------Bildirimler - --------*/
        Route::resource('notification', \App\Http\Controllers\PersonelAccount\Notification\PersonelNotificationController::class)->only([
            'index', 'show', 'destroy'
        ]);
        /*------ Randevular -----------*/
        Route::apiResource('appointment', \App\Http\Controllers\PersonelAccount\Appointment\PersonelAppointmentController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        /*------- Randevu Fotoğrafları----------*/
        Route::prefix('appointment')->group(function () {
            Route::get('/{appointment}/photo/list', [\App\Http\Controllers\Appointment\AppointmentPhotoController::class, 'index']);
            Route::post('/{appointment}/photo/add', [\App\Http\Controllers\Appointment\AppointmentPhotoController::class, 'store']);
            Route::delete('/{appointmentPhoto}/photo/delete', [\App\Http\Controllers\Appointment\AppointmentPhotoController::class, 'destroy']);
        });
        /*--------İzinler --------------*/
        Route::apiResource('stay-off-day', \App\Http\Controllers\PersonelAccount\StayOffDay\PersonelStayOffDayController::class)->only([
            'index', 'create', 'store', 'destroy'
        ]);
        /*--------Kasa --------------*/
        Route::get('/case', [\App\Http\Controllers\PersonelAccount\Case\PersonelCaseController::class, 'case']);

    });
});
