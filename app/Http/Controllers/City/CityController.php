<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location\CityResource;
use App\Models\Appointment;
use App\Services\NotificationService;
use App\Services\OneSignalNotification;
use Illuminate\Http\Request;

use Berkayk\OneSignal\OneSignalClient;
use OneSignal;

/**
 *
 * @group City
 *
 **/
class CityController extends Controller
{
    /**
     *
     * GET api/city/list
     *
     * Şehir Listesi. Direk get isteği atılacak Header veya body gönderimine gerek yok
     * @group City
     *
     *
     * */
    public function index()
    {
        $cities = \App\Models\City::all();
        return response()->json([
            'cities' => CityResource::collection($cities)
        ]);
    }

    /**
     *POST api/city/get
     *
     * City id gönderilen şehrin bilgilerini ve ilçe verisini döndürür.
     * city_id |required| int or string
     *
     * @group City
     *
     *
     **/
    public function get(Request $request)
    {
        $city = \App\Models\City::find($request->input('city_id'));

        if ($city) {
            return response()->json([
                'status' => "success",
                'city' => CityResource::make($city),
                'districts' =>$city->district,
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Şehir Bulunamadı"
        ]);
    }

    public function testNotify(Request $request)
    {
        //$response = NotificationService::sendPushNotification('ExponentPushToken[QH16C6HAvJ9pFaVKJ8WKxu]', 'Yeni talep var', 'Test Talep Açıklama');
        $appointment = Appointment::find(12269);

        // Hatırlatma mesajını gönderme kodu buraya gelecek
        $customer = $appointment->customer;
        $business = $appointment->business;
        /*
        $message = "Değerli Müşterimiz, {$business->name} işletmesinden aldığınız {$appointment->start_time->format('d.m.Y H:i')} randevusu için bir hatırlatma mesajıdır. Zamanında gelmenizi rica ederiz. Teşekkürler.";
        //Sms::send($customer->phone, $message);*/
        $message = $business->name . " İşletmesine " . $appointment->start_time->format('d.m.Y H:i') . " tarihine randevunuz oluşturuldu. Konum : ".'https://www.google.com/maps?q=' . $business->lat .','. $business->longitude;

        $response = NotificationService::sendPushNotification('ExponentPushToken[XjuhgWGCUle6TuRCxPMDTi]', 'Randevu Hatırlatma', $message);

        return response()->json([
            'message' => 'Notification sent successfully',
            'response' => $response,
        ]);
    }
}
