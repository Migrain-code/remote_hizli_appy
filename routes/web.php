<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\HomeController::class)->group(function (){
    Route::get('language/{locale}', 'language')->name('language');
    Route::get('/', 'index')->name('welcome');
    Route::post('/bilgi-al', 'getInfo')->name('getInfo');
    Route::get('/kategori-detay/{slug}', 'categoryDetail')->name('categoryDetail');
    Route::get('/paketler', 'packages')->name('packages');
    Route::get('/destek', 'faq')->name('faq');
    Route::get('/iletisim', 'contact')->name('contact');
    Route::post('/iletisim', 'sendMessage')->name('contact.sendMessage');
    Route::get('/bloglar', 'blogs')->name('blog.index');
    Route::get('/blog/detay/{slug}', 'blogDetail')->name('blog.detail');
    Route::get('/ozellikler', 'proparties')->name('propartie.index');
    Route::get('ozellikler/detay/{slug}', 'propartie')->name('propartie.detail');
});
Route::group(['prefix' => 'business', 'as' => 'business.'], function () {
    Route::get('/login', [\App\Http\Controllers\Business\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Business\Auth\LoginController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Business\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Business\Auth\RegisterController::class, 'register']);
    Route::get('/verify/phone', [\App\Http\Controllers\Business\Auth\VerifyController::class, 'index'])->name('verify.showForm');
    Route::post('/verify', [\App\Http\Controllers\Business\Auth\RegisterController::class, 'verify'])->name('verify');
    Route::get('/logout', [\App\Http\Controllers\Business\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/sifremi-unuttum', [\App\Http\Controllers\Business\Auth\VerifyController::class, 'showForgotView'])->name('showForgotView');
    Route::post('/sifremi-unuttum', [\App\Http\Controllers\Business\Auth\VerifyController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('/verify/mobil', [\App\Http\Controllers\Business\Auth\VerifyController::class, 'verify'])->name('verifyPhone');
    Route::middleware(['auth:official', 'active', 'setup_status'])->group(function () {
        Route::controller(\App\Http\Controllers\SetupController::class)->prefix('isletme-kurulum')->as('setup.')->group(function (){
            Route::get('/adim-1', 'step1')->name('step1');
            Route::post('/adim-1', 'step1Form')->name('step1Form');
            Route::get('/adim-2', 'step2')->name('step2');
            Route::post('/adim-2', 'step2Form')->name('step2Form');
            Route::get('/adim-3', 'step3')->name('step3');
            Route::post('/adim-3', 'step3Form')->name('step3Form');
            Route::get('/adim-4', 'step4')->name('step4');
            Route::post('/adim-4', 'step4Form')->name('step4Form');
            Route::get('/adim-5', 'step5')->name('step5');
        });
        Route::get('/home', [\App\Http\Controllers\Business\HomeController::class, 'index'])->name('home');
        Route::post('/update-password', [\App\Http\Controllers\Business\HomeController::class,'resetPassword'])->name('resetPassword');
        Route::resource('gallery', \App\Http\Controllers\Business\BusinessGalleryController::class)->names('gallery');
        Route::resource('productSale', \App\Http\Controllers\Business\ProductSalesController::class);
        Route::post('product-price', [\App\Http\Controllers\Business\ProductSalesController::class, 'productPrice'])->name('product.price');
        Route::resource('packageSale', \App\Http\Controllers\Business\PackageSaleController::class);
        Route::resource('customer', \App\Http\Controllers\Business\CustomerController::class);
        Route::resource('appointment', \App\Http\Controllers\Business\AppointmentController::class);
        Route::get('appointment/reject/{id}', [\App\Http\Controllers\Business\AppointmentController::class, 'reject'])->name('appointment.reject');
        Route::get('appointment/accept/{id}', [\App\Http\Controllers\Business\AppointmentController::class, 'accept'])->name('appointment.accept');
        Route::resource('businessNote', \App\Http\Controllers\Business\BusinessNoteController::class);
        Route::post('personelService', [\App\Http\Controllers\Business\AppointmentController::class, 'personel'])->name('personelService');
        Route::post('businessCustomer/{id}', [\App\Http\Controllers\Business\CustomerController::class, 'delete'])->name('customer.delete');
        Route::post('packagePayments', [\App\Http\Controllers\Business\PackageSaleController::class, 'payments'])->name('package.payments');
        Route::post('packagePaymentsAdd', [\App\Http\Controllers\Business\PackageSaleController::class, 'paymentsAdd'])->name('package.payments.add');
        Route::post('package-usages', [\App\Http\Controllers\Business\PackageSaleController::class, 'usages'])->name('package.usages');
        Route::post('package-usages-add', [\App\Http\Controllers\Business\PackageSaleController::class, 'usagesAdd'])->name('package.usages.add');
        Route::resource('product', \App\Http\Controllers\Business\ProductController::class);
        Route::post('city', [\App\Http\Controllers\Business\HomeController::class, 'district'])->name('city');
        Route::post('subCategory', [\App\Http\Controllers\Business\HomeController::class, 'subCategory'])->name('subCategory');
        Route::resource('personel', \App\Http\Controllers\Business\PersonelController::class);
        Route::post('send/notification', [\App\Http\Controllers\Business\PersonelController::class, 'sendNotification'])->name('sendNotification');
        Route::post('/notification/get', [\App\Http\Controllers\Business\PersonelController::class, 'get'])->name('notification.get');
        Route::resource('businessNotification', \App\Http\Controllers\BusinessNotificationController::class);
        Route::post('gender', [\App\Http\Controllers\Business\PersonelController::class, 'gender'])->name('gender');
        Route::post('serviceGender', [\App\Http\Controllers\Business\BusinessServiceController::class, 'gender'])->name('service.gender');
        Route::post('category', [\App\Http\Controllers\Business\BusinessServiceController::class, 'category'])->name('service.category');
        Route::resource('businessService', \App\Http\Controllers\Business\BusinessServiceController::class);
        Route::post('subCategory', [\App\Http\Controllers\Business\HomeController::class, 'subCategory'])->name('subCategory');

        Route::controller(\App\Http\Controllers\Business\BusinessController::class)->prefix('profile')->as('profile.')->group(function () {
            Route::get('/profilim', 'show')->name('show');
            Route::post('/update-general-setting', 'update')->name('updateGeneralSetting');
            Route::post('/update-owner-setting', 'updateOwner')->name('updateOwnerSetting');
            Route::post('/update-work-time', 'updateWorkTime')->name('updateWorkTime');
        });
    });
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::get('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
    Route::middleware('cookieAccess')->group(function(){});
    Route::middleware('auth:admin')->group(function () {
        Route::get('/home', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
        Route::resource('featuredCategorie', \App\Http\Controllers\Admin\FeaturedCategorieController::class);
        Route::resource('recommendedLink', \App\Http\Controllers\RecommendedLinkController::class);
        Route::resource('page', \App\Http\Controllers\Admin\PageController::class);
        Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('faq', \App\Http\Controllers\Admin\FaqController::class);
        Route::resource('sponsor', \App\Http\Controllers\Admin\SponsorController::class);
        Route::resource('blog', \App\Http\Controllers\Admin\BlogController::class);
        Route::resource('blogComment', \App\Http\Controllers\BlogCommentController::class);
        Route::resource('activity', \App\Http\Controllers\Admin\ActivityController::class);
        Route::resource('comment', \App\Http\Controllers\Admin\CommentController::class);
        Route::resource('faq', \App\Http\Controllers\Admin\FaqController::class);
        Route::resource('businessFaq', \App\Http\Controllers\Admin\BusinessFaqController::class);
        Route::resource('businessBlog', \App\Http\Controllers\Admin\BusinessBlogController::class);
        Route::resource('socialMedia', \App\Http\Controllers\Admin\SocialMediaController::class);
        Route::resource('ads', \App\Http\Controllers\Admin\AdsController::class);
        Route::resource('page', \App\Http\Controllers\Admin\PageController::class);
        Route::resource('businessInfo', \App\Http\Controllers\Admin\BusinessInfoController::class);
        Route::resource('swiper', \App\Http\Controllers\Admin\SwiperController::class);
        Route::resource('activitySponsor', \App\Http\Controllers\Admin\ActivitySponsorController::class);
        Route::resource('business', \App\Http\Controllers\Admin\BusinessController::class);
        Route::post('/business/add-service', [\App\Http\Controllers\Admin\BusinessController::class, 'addService'])->name('business.addService');
        Route::resource('propartie', \App\Http\Controllers\Admin\PropartieController::class);
        Route::resource('bussinessPackagePropartieList', \App\Http\Controllers\Admin\BussinessPackagePropartieListController::class);
        Route::resource('businessPackage', \App\Http\Controllers\Admin\BussinessPackageController::class);
        Route::resource('businnessType', \App\Http\Controllers\Admin\BusinnessTypeController::class);
        Route::resource('serviceCategory', \App\Http\Controllers\Admin\ServiceCategoryController::class);
        Route::resource('serviceSubCategory', \App\Http\Controllers\Admin\ServiceSubCategoryController::class);
        /*single form post start*/
        Route::post('activity/store/business', [\App\Http\Controllers\Admin\ActivityController::class, 'storeBusiness'])->name('activity.storeBusiness');
        /*single form post end*/
        Route::controller(\App\Http\Controllers\Admin\ForBusinessController::class)->prefix('forBusiness')->as('forBusiness.')->group(function (){
            Route::get('index', 'index')->name('index');
            Route::post('section-update', 'section_update')->name('section_update');
            Route::post('swiper-update', 'swiperUpdate')->name('swiper_update');
        });
        /*Ajax Post Url Start*/
        Route::post('info/update-status', [\App\Http\Controllers\Admin\BusinessInfoController::class, 'updateStatus'])->name('businessInfo.updateStatus');
        Route::post('page/update-status', [\App\Http\Controllers\Admin\PageController::class, 'updateStatus'])->name('page.updateStatus');
        Route::post('activity/cancelled', [\App\Http\Controllers\Admin\ActivityController::class, 'activityCancelled'])->name('activity.cancelledBusiness');
        Route::post('comment/update-status', [\App\Http\Controllers\Admin\CommentController::class, 'updateStatus'])->name('comment.updateStatus');
        Route::post('activity/update-status', [\App\Http\Controllers\Admin\ActivityController::class, 'updateStatus'])->name('activity.updateStatus');
        Route::post('blog/update-status', [\App\Http\Controllers\Admin\BlogController::class, 'updateStatus'])->name('blog.updateStatus');
        Route::post('business/blog/update-status', [\App\Http\Controllers\Admin\BusinessBlogController::class, 'updateStatus'])->name('businessBlog.updateStatus');

        Route::post('city', [\App\Http\Controllers\Admin\HomeController::class, 'district'])->name('city');
        Route::post('subCategory', [\App\Http\Controllers\Admin\HomeController::class, 'subCategory'])->name('subCategory');

        /*Ajax Post Url end*/
        Route::get('/update-category', [\App\Http\Controllers\Admin\SettingController::class, 'uCategory']);
        Route::get('/business-settings', [\App\Http\Controllers\Admin\SettingController::class, 'businessEdit'])->name('business.settings');
        Route::get('/user-settings', [\App\Http\Controllers\Admin\SettingController::class, 'userEdit'])->name('user.settings');
        /*Route::get('/business-main-page', [\App\Http\Controllers\Admin\SettingController::class, 'businessEdit'])->name('business.settings');*/
        Route::get('/anasayfa/guncelle', [\App\Http\Controllers\Admin\MaingPageController::class, 'userEdit'])->name('user.mainPage');

        Route::post('/main-page-update', [\App\Http\Controllers\Admin\MaingPageController::class, 'section_update'])->name('user.mainPage.update');

        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    });
});