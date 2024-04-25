<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessInfo\BusinessInfoUpdateRequest;
use App\Http\Requests\Setup\DetailSetupRequestStep1;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessOfficialResource;
use App\Models\AppointmentRange;
use App\Models\BusinnessType;
use App\Models\DayList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/**
 * @group BusinessHome
 *
 * */
class HomeController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }
    /**
     * İşletme anasayfa apisi
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        return response()->json([
            'appointmentCount' => "5",
            'productSale' => "150",
            'adisyonCount' => "56",
            'totalCount' => "240",
            'newCustomerCount' => "500",
            'totalCustomerCount' => "750",
        ]);

    }

    /**
     * İşletme Bilgileri
     * @return \Illuminate\Http\JsonResponse
     */
    public function setting()
    {
        $commissions=[];
        for ($i = 0; $i <= 100; $i++){
            $commissions[]= [
                'id' => $i,
                'name' => "%". $i
            ];
        }
        return response()->json([
            'dayList' => DayList::all(),
            'businessTypeList' => BusinnessType::all(),
            'appointmentRanges' => AppointmentRangeResource::collection(AppointmentRange::all()),
            'commissions' => $commissions,
            'aboutText' => "Test Mesaj",
        ]);
    }
    /**
     * İşletme Bilgileri Güncelle
     * @return \Illuminate\Http\JsonResponse
     */
    public function settingUpdate(BusinessInfoUpdateRequest $request)
    {
        $business = $this->business;

        $business->name = $request->input('businessName');// Salon Adı
        $business->off_day = $request->input('offDay');
        $business->appoinment_range = $request->input('appointmentRange');
        $business->type_id = $request->input('businessType');
        $business->phone = $request->input('phone');
        $business->start_time = $request->input('startTime');
        $business->end_time = $request->input('endTime');
        $business->business_email = $request->input('email');
        $business->year = Carbon::parse($request->input('year'))->format('Y-m-d'); //2023-04-01
        $business->personal_count = $request->input('personalCount');
        $business->address = $request->input('address');
        $business->about = $request->input('aboutText');
        $business->city = $request->input('cityId');
        $business->district = $request->input('districtId');
        $business->commission = $request->input('commission');
        $business->save();

        return response()->json([
            'status' => "success",
            'message' => "İşletme Bilgileri Kayıt Edildi"
        ]);
    }
}
