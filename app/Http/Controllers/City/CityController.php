<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use App\Http\Resources\Location\CityResource;
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
        $oneSignalService = new OneSignalNotification();
        $response = $oneSignalService->sendNotification(1, 'TEST');

        return response()->json([
            'message' => 'Notification sent successfully',
            'response' => $response,
        ]);
    }
}
