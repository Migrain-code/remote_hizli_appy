<?php
//Personel Apileri
Route::prefix('personel')->group(function () {
    Route::prefix('auth')->group(function (){
        Route::post('login', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'login']);
    });

    Route::middleware('auth:personel')->group(function () {
        Route::post('logout', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'logout']);

        Route::get('/today/appointment', [\App\Http\Controllers\Personel\HomeController::class, 'getClock']);

        /*------- Hesabım Apisi -----------*/
        Route::apiResource('profile', \App\Http\Controllers\PersonelAccount\Profile\PersonalProfileUpdateController::class)->only([
            'index', 'create', 'store'
        ]);
        /*------Bildirim İzinleri- --------*/
        Route::apiResource('notification-permission', \App\Http\Controllers\PersonelAccount\Notification\PersonelNotificationPermissionController::class)->only([
            'index', 'update'
        ]);
        /*------Bildirimler - --------*/
        Route::apiResource('notification', \App\Http\Controllers\PersonelAccount\Notification\PersonelNotificationController::class)->only([
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
        /*------- Randevu Oluştur----------*/
        Route::prefix('appointment-create')->controller(\App\Http\Controllers\PersonelAccount\Appointment\PersonelAppointmentCreateController::class)->group(function () {
            Route::get('get/services', 'getService');
            Route::get('get/customers', 'getCustomer');
            //Route::post('get/personel', 'getPersonel');
            Route::post('get/date', 'getDate');
            Route::post('get/clock', 'getClock');
            Route::post('/', 'appointmentCreate');
            Route::post('/summary', 'summary');
        });
    });
});
