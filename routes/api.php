<?php

use App\Http\Controllers\Absent\AbsentCustomerController;
use App\Http\Controllers\Adission\AdissionAddCashPointController;
use App\Http\Controllers\Adission\AdissionController;
use App\Http\Controllers\Adission\AdissionPaymentController;
use App\Http\Controllers\Adission\AdissionProductSaleController;
use App\Http\Controllers\Api\OfficialCreditCardController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Appointment\AppointmentController;
use App\Http\Controllers\Appointment\AppointmentCreateController;
use App\Http\Controllers\Appointment\AppointmentPhotoController;
use App\Http\Controllers\Appointment\AppointmentReceivableController;
use App\Http\Controllers\Appointment\AppointmentServicesController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Birthday\BirthdayController;
use App\Http\Controllers\Branche\BusinessBrancheController;
use App\Http\Controllers\Case\CaseController;
use App\Http\Controllers\City\CityController;
use App\Http\Controllers\Cost\BusinessCostController;
use App\Http\Controllers\Customer\BusinessCustomerNoteController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CustomerGalleryController;
use App\Http\Controllers\Customer\CustomerInfoController;
use App\Http\Controllers\Deps\BusinessDepController;
use App\Http\Controllers\Gallery\GalleryController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Notification\BusinessNotificationPermissionController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Official\BusinessOfficialController;
use App\Http\Controllers\PackageSale\PackageSaleController;
use App\Http\Controllers\PackageSale\PackageSaleOperationController;
use App\Http\Controllers\Personel\PersonalController;
use App\Http\Controllers\Personel\PersonelController;
use App\Http\Controllers\Personel\PersonelStayOffDayController;
use App\Http\Controllers\Personel\PrimController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProductSale\ProductSaleController;
use App\Http\Controllers\Promossion\BusinessPromossionController;
use App\Http\Controllers\Service\BusinessServiceController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Setup\DetailSetupController;
use App\Http\Controllers\Setup\SetupController;
use App\Http\Controllers\Subscription\SubscribtionController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\BusinessDeviceNotificationPermissionController;
use App\Http\Controllers\Room\BusinessRoomController;
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
require_once 'guards/personal.php';

Route::prefix('city')->group(function () {
    Route::get('list', [CityController::class, 'index']);
    Route::post('get', [CityController::class, 'get']);
});
Route::post('test/notify', [CityController::class, 'testNotify']);
Route::prefix('business')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('check-phone', [AuthController::class, 'register']);
        Route::post('verify', [AuthController::class, 'verify']);
        Route::post('reset-password', [AuthController::class, 'passwordReset']);
        Route::post('verify-reset-password', [AuthController::class, 'verifyResetPassword']);

        Route::middleware('auth:official')->group(function () {
            Route::get('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });
    Route::middleware('auth:official')->group(function () {
        Route::post('update-password', [HomeController::class, 'updatePassword']);
        Route::get('delete-account', [HomeController::class, 'deleteAccount']);
        Route::get('notification-count', [HomeController::class, 'notificationCount']);
        Route::controller(HomeController::class)->prefix('home')->group(function () {
            Route::get('/', 'index');
            Route::get('personel-appointment/{personel}', 'getPersonelClock');
        });
        Route::controller(HomeController::class)->prefix('setting')->group(function () {
            Route::get('/', 'setting');
            Route::post('/update', 'settingUpdate');
        });
        /** -------------------------------- Kurulum Rotaları --------------------------------------- */
        Route::controller(SetupController::class)->prefix('setup')->group(function () {
            Route::get('/get', 'get');
            Route::post('/update', 'update');
        });

        Route::controller(OfficialCreditCardController::class)->prefix('cart')->group(function () {
            Route::get('/', 'index');
            Route::post('/get', 'get');
            Route::post('/delete', 'delete');
            Route::post('/save', 'store');
            Route::post('/update', 'update');
        });
        Route::controller(PaymentController::class)->prefix('payment')->group(function () {
            Route::get('/', 'index');
            Route::post('/pay', 'pay');
        });

        Route::controller(DetailSetupController::class)->prefix('detail-setup')->group(function () {
            Route::get('/step-1/get', 'index');
            Route::post('/step-1/update', 'step1');
            Route::post('/step-1/upload/logo', 'uploadLogo');
            Route::post('/step-1/upload/gallery', 'uploadGallery');
        });

        Route::controller(BusinessServiceController::class)->prefix('business-service')->group(function () {
            Route::get('/', 'step2Get');
            Route::post('/get', 'step2GetService');
            Route::post('/add', 'step2AddService');
            Route::post('/update', 'step2UpdateService');
            Route::post('/delete', 'step2DeleteService');
            /*Route::post('/update/logo', 'updateLogo');*/
        });

        Route::controller(PersonalController::class)->prefix('personal')->group(function () {
            Route::get('/', 'step3Get');
            Route::get('/add/get', 'step3AddPersonalGet');
            Route::post('/get', 'step3GetPersonal');
            Route::post('/add', 'step3AddPersonal');
            Route::post('/update', 'step3UpdatePersonal');
            Route::post('/delete', 'step3DeletePersonal');
        });
        /** -------------------------------- Ürünler --------------------------------------- */
        Route::apiResource('product', ProductController::class);

        /** -------------------------------- Müşteriler --------------------------------------- */
        Route::apiResource('customer', CustomerController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        Route::prefix('customer/{customer}')->group(function () {
            Route::get('cash-point', [CustomerInfoController::class, 'cashPointList']);
            Route::get('product-sale', [CustomerInfoController::class, 'productSaleList']);
            Route::get('package-sale', [CustomerInfoController::class, 'packageSaleList']);
            Route::get('receivable', [CustomerInfoController::class, 'receivableList']);
            Route::get('payment', [CustomerInfoController::class, 'payments']);
            Route::get('comment', [CustomerInfoController::class, 'comments']);
        });

        Route::apiResource('customerNote', BusinessCustomerNoteController::class);
        Route::apiResource('customerGallery', CustomerGalleryController::class);

        /** -------------------------------- Personeller --------------------------------------- */

        Route::apiResource('personel', PersonelController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        Route::prefix('personel')->group(function () {
            Route::get('{personel}/case', [PersonelController::class, 'case']);
            Route::post('send/notification', [PersonelController::class, 'sendNotify']);
            Route::get('set-safe/{personel}', [PersonelController::class, 'setCase']);
        });

        /** -------------------------------- Ürün Satışı --------------------------------------- */
        Route::apiResource('product-sale', ProductSaleController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        /** -------------------------------- Paket Satışı --------------------------------------- */
        Route::apiResource('package-sale', PackageSaleController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        Route::prefix('package-sale')->group(function () {
            Route::get('/{packageSale}/payments', [PackageSaleOperationController::class, 'payments']);
            Route::get('/{packageSale}/usages', [PackageSaleOperationController::class, 'usages']);

            Route::post('/{packageSale}/add-payment', [PackageSaleOperationController::class, 'paymentsAdd']);
            Route::post('/{packageSale}/add-usage', [PackageSaleOperationController::class, 'usagesAdd']);

            Route::delete('/{packagePayment}/delete-payment', [PackageSaleOperationController::class, 'deletePayment']);
            Route::delete('/{packageUsage}/delete-usage', [PackageSaleOperationController::class, 'deleteUsage']);
        });
        /** -------------------------------- İzinler --------------------------------------- */

        Route::apiResource('personel-stay-off-day', PersonelStayOffDayController::class)->only([
            'index', 'create', 'store', 'destroy'
        ]);

        /** -------------------------------- Randevular --------------------------------------- */

        Route::apiResource('appointment', AppointmentController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        /** -----------------------------Randevuya Hizmet Ekleme ---------------------- */
        Route::prefix('appointment')->group(function () {
            Route::get('/{appointment}/service/list', [AppointmentServicesController::class, 'index']);
            Route::post('/{appointment}/service/add', [AppointmentServicesController::class, 'store']);
            Route::delete('/{appointmentServices}/service/delete', [AppointmentServicesController::class, 'destroy']);
        });

        /** -----------------------------Randevuya Fotoğraf Ekleme ---------------------- */
        Route::prefix('appointment')->group(function () {
            Route::get('/{appointment}/photo/list', [AppointmentPhotoController::class, 'index']);
            Route::post('/{appointment}/photo/add', [AppointmentPhotoController::class, 'store']);
            Route::delete('/{appointmentPhoto}/photo/delete', [AppointmentPhotoController::class, 'destroy']);
        });

        /** -------------------------------------- Adisyonlar ----------------------------------------- */
        Route::apiResource('adission', AdissionController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        Route::prefix('adission')->group(function () {
            Route::get('/{adission}/sale/list', [AdissionProductSaleController::class, 'index']);
            Route::get('/{adission}/sale/create', [AdissionProductSaleController::class, 'create']);
            Route::post('/{adission}/sale/add', [AdissionProductSaleController::class, 'store']);
            Route::get('/{productSale}/sale/edit', [AdissionProductSaleController::class, 'edit']);
            Route::put('/{adission}/sale/{productSale}/update', [AdissionProductSaleController::class, 'update']);
            Route::delete('/{productSale}/sale/delete', [AdissionProductSaleController::class, 'destroy']);

            Route::get('/{adission}/payment', [AdissionPaymentController::class, 'index']);//tahsilat listesi
            Route::get('/{adission}/payment/create', [AdissionPaymentController::class, 'create']);//tahsilat oluştur
            Route::post('/{adission}/payment/add', [AdissionPaymentController::class, 'store']);//tahsilat ekle
            Route::get('/{adission}/payment/{payment}/edit', [AdissionPaymentController::class, 'edit']);// tahsilat düzenle
            Route::put('/{adission}/payment/{payment}', [AdissionPaymentController::class, 'update']);//tahsilat güncelle
            Route::delete('/{adission}/payment/{payment}', [AdissionPaymentController::class, 'destroy']);//tahsilat sil

            Route::post('/{adission}/payment/save', [AdissionPaymentController::class, 'paymentSave']);
            Route::get('/{adission}/payment/close', [AdissionPaymentController::class, 'closePayment']);

            //Parapuan Kullan
            Route::get('/{adission}/cash-point/add', [AdissionAddCashPointController::class, 'index']);
            Route::get('/{adission}/cash-point/{cashPoint}/use', [AdissionAddCashPointController::class, 'store']);

            //Alacak Ekle
            Route::get('/{adission}/receivable', [AdissionAddCashPointController::class, 'receivableList']);
            Route::post('/{adission}/receivable', [AdissionAddCashPointController::class, 'receivableAdd']);
            Route::delete('/{adission}/receivable/{receivable}', [AdissionAddCashPointController::class, 'receivableDelete']);
            Route::put('/{adission}/receivable/{receivable}', [AdissionAddCashPointController::class, 'receivableUpdate']);
        });

        /** -------------------------------------- Promosyonlar ----------------------------------------- */
        Route::apiResource('promossion', BusinessPromossionController::class)->only([
            'index', 'store',
        ]);
        /** -------------------------------- Randevu Oluşturma --------------------------------------- */

        Route::prefix('appointment-create')->controller(AppointmentCreateController::class)->group(function () {
            Route::get('personel', 'getPersonel');
            Route::get('services', 'getService');
            Route::get('date', 'getDate');
            Route::get('clock', 'getClock');
            Route::get('customers', 'getCustomer');
            Route::get('/summary', 'summary');
            Route::post('/', 'appointmentCreate');
        });
        /** -------------------------------- Hizmetler --------------------------------------- */
        Route::apiResource('service', ServiceController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        /** -------------------------------- Galeri --------------------------------------- */
        Route::apiResource('gallery', GalleryController::class)->only([
            'index', 'store', 'destroy'
        ]);
        /** -------------------------------- Yetkililer --------------------------------------- */
        Route::apiResource('official', BusinessOfficialController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
        /** -------------------------------- Şubeler --------------------------------------- */
        Route::apiResource('branche', BusinessBrancheController::class)->only([
            'index', 'create','edit', 'store', 'update', 'destroy'
        ]);
        /** -------------------------------- Bildirim İzinleri --------------------------------------- */
        Route::apiResource('notification-permission', BusinessNotificationPermissionController::class)->only([
            'index', 'update'
        ]);
        /** -------------------------------- Cihaz Bildirim İzinleri --------------------------------------- */
        Route::apiResource('device-notification-permission', BusinessDeviceNotificationPermissionController::class)->only([
            'index', 'update'
        ]);
        /** -------------------------------- Bildirimler --------------------------------------- */
        Route::apiResource('notification', NotificationController::class)->only([
            'index', 'show', 'destroy'
        ]);
        // parapuan bildirimleri
        Route::get('cash-point-notification', [NotificationController::class, 'cashPointNotification']);

        /** -------------------------------- Doğum Günleri --------------------------------------- */
        Route::apiResource('birthday', BirthdayController::class)->only([
            'index', 'create', 'store'
        ]);

        /** -------------------------------- Gelmeyenler --------------------------------------- */
        Route::apiResource('customer-absent', AbsentCustomerController::class)->only([
            'index',
        ]);

        /** ------------------------------- Abonelik ------------------------------------ */

        Route::apiResource('subscribtion', SubscribtionController::class)->only([
            'index',
        ]);

        /** ------------------------------- Masraflar ------------------------------------ */
        Route::apiResource('cost', BusinessCostController::class)->only([
            'index', 'create', 'store', 'edit', 'update', 'destroy'
        ]);

        /** ------------------------------- Alacaklar ------------------------------------ */
        Route::apiResource('receivable', AppointmentReceivableController::class)->only([
            'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
        ]);

        /** ------------------------------- Borçlar ------------------------------------ */
        Route::apiResource('dep', BusinessDepController::class)->only([
            'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
        ]);
        /** ------------------------------- Yorumlar ------------------------------------ */
        Route::apiResource('comment', \App\Http\Controllers\BusinessCommentController::class)->only([
            'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
        ]);
        /** ------------------------------- Kasa ------------------------------------ */
        Route::get('case', [CaseController::class, 'index']);

        /** ------------------------------- Prim ------------------------------------ */
        Route::get('prim', [PrimController::class, 'index']);

        /** -------------------------------- Odalar --------------------------------------- */
        Route::apiResource('room', BusinessRoomController::class)->only([
            'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
        ]);
    });
});
