<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessInfo\BusinessInfoUpdateRequest;
use App\Http\Requests\Password\PasswordUpdateRequest;
use App\Http\Requests\Setup\DetailSetupRequestStep1;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessOfficialResource;
use App\Http\Resources\Business\BusinessResource;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Models\AppointmentRange;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @group BusinessHome
 *
 * */
class HomeController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->business = $this->user->business;
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
        $todayAppointments = $this->getClock(now());
        $adissions = $this->business->appointments()->whereIn('status', [5, 6])->get();
        $adissionTotal = 0;
        foreach ($adissions as $adission){
            $adissionTotal += $adission->calculateCollectedTotal(); // tahsil edilecklerin toplamı
        }
        return response()->json([
            'appointmentCount' => $this->business->appointments->count(),
            'productSale' => $this->business->sales->count(),//toplam ürün satışı
            'adisyonCount' =>  formatPrice($adissionTotal), //adisyon toplamı
            'totalCount' => $this->business->packages->count(), //toplam paket satışı
            'newCustomerCount' => $this->business->customers->count(),
            'totalCustomerCount' => $this->business->customers->count(),
            'appointments' => $todayAppointments,
        ]);

    }
    public function getClock($appointmentDate)
    {
        $business = $this->business;
        $clocks = [];
        $getDate = Carbon::parse($appointmentDate);
        $i = Carbon::parse($getDate->format('Y-m-d').' '.$business->start_time);
        $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$business->end_time);

        while ($i < $endTime){

            $getAppointment = $business->appointments()->whereHas('services')->where('start_time', $i->toDateTime())->first();

            $clocks[] = [
                'id' =>isset($getAppointment) ? $getAppointment->id : '',
                'clock' => $i->format('H:i'),
                'title' =>isset($getAppointment) ? $getAppointment->services->first()->service->subCategory->name : 'Boş',
                'customer' =>isset($getAppointment) ? $getAppointment->customer->name : "",
                'color_code' =>  isset($getAppointment) ? $getAppointment->status('color') : '#5dc26b',
            ];

            $i->addMinute($business->range->time);
        }

        return $clocks;
    }
    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = $this->user;
        $user->password = Hash::make($request->input('password'));
        if ($user->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Şifreniz Güncellendi"
            ]);
        }
    }

    public function notificationCount()
    {
        return response()->json($this->user->notifications()->count());
    }
    public function deleteAccount()
    {
        $user = $this->user;
        $user->status = 0;
        if ($user->save()){
            return response()->json([
                'status' => "success",
                'message' => "Hesabınız ve işletme bilgileriniz başarılı bir şekilde silindi"
            ]);
        }
    }
    /**
     * İşletme Bilgileri
     * @return \Illuminate\Http\JsonResponse
     */
    public function setting()
    {
        $commissions = [];
        for ($i = 0; $i <= 100; $i++) {
            $commissions[] = [
                'id' => $i,
                'name' => "%" . $i
            ];
        }
        return response()->json([
            'dayList' => DayList::all(),
            'businessTypeList' => BusinnessType::all(),
            'appointmentRanges' => AppointmentRangeResource::collection(AppointmentRange::all()),
            'commissions' => $commissions,
            'aboutText' => "Test Mesaj",
            'business'=> BusinessResource::make($this->business)
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
        if ($request->hasFile('logo')) {
            $response = UploadFile::uploadFile($request->file('logo'), 'business_logos');
            $business->logo = $response["image"]["way"];
        }
        $business->save();

        return response()->json([
            'status' => "success",
            'message' => "İşletme Bilgileri Kayıt Edildi",
        ]);
    }
}
