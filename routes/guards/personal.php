<?php
//Personel Apileri
Route::prefix('personel')->group(function () {
    Route::prefix('auth')->group(function (){
        Route::get('show-login', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'showLogin']);
        Route::post('login', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'login']);
        Route::post('reset-password', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'passwordReset']);
        Route::post('verify-reset-password', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'verifyResetPassword']);
        Route::post('save-token', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'saveToken']);
    });

    Route::middleware('auth:personel')->group(function () {
        Route::get('user', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'user']);
        Route::post('update-password', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'updatePassword']);
        Route::post('logout', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'logout']);
        Route::get('delete-account', [\App\Http\Controllers\PersonelAccount\PersonalAuthController::class, 'deleteAccount']);
        Route::prefix('home')->group(function (){
            Route::get('/day-list', [\App\Http\Controllers\Personel\HomeController::class, 'getDate']);
            Route::get('/', [\App\Http\Controllers\Personel\HomeController::class, 'getClock']);
        });

        /*------- Saat Kapatma -----------*/
        Route::prefix('speed-appointment')
            ->controller(\App\Http\Controllers\PersonelAccount\SpeedAppointment\SpeedAppointmentController::class)
            ->group(function (){
                Route::get('/', 'index')->name('index');
                Route::get('customer', 'getCustomerList');
                Route::post('add/customer', 'newCustomer');
                Route::get('personel/list', 'getPersonelList');
                Route::get('personel/{personel}/services', 'getPersonelServiceList');
                Route::get('personel/{personel}/clocks', 'getPersonelClocks');
                Route::post('personel/{personel}/create', 'appointmentCreate');
            });
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
            'index', 'store','show', 'destroy'
        ]);
        /*------ Randevular -----------*/
        Route::apiResource('appointment', \App\Http\Controllers\PersonelAccount\Appointment\PersonelAppointmentController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        Route::prefix('appointment/{appointment}')->group(function () {
            Route::get('approve', [\App\Http\Controllers\PersonelAccount\Appointment\PersonelAppointmentController::class, 'approve']);
        });
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
