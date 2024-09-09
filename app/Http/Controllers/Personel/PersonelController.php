<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personel\PersonalAddRequest;
use App\Http\Requests\Personel\PersonalUpdateRequest;
use App\Http\Requests\Personel\PersonelNotificationAddRequest;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Location\DayListResource;
use App\Http\Resources\Personel\MaasListResource;
use App\Http\Resources\Personel\PersonelAppointmentResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Personel\PersonelResource;
use App\Models\AppointmentRange;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelNotification;
use App\Models\PersonelRestDay;
use App\Models\PersonelService;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @group PersonelInfo
 *
 * */
class PersonelController extends Controller
{
    /**
     * Personel Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        $personels = $business->personels;
        return response()->json(PersonelListResource::collection($personels));
    }

    /**
     * Personel Oluştur
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        $rates = [];
        for ($i = 0; $i <= 100; $i++) {
            $rates[] = [
                'id' => $i,
                'name' => $i . "%",
            ];
        }
        $product_rates = [];
        for ($j = 0; $j <= 100; $j++) {
            $product_rates[] = [
                'id' => $j,
                'name' => $j . "%",
            ];
        }
        return response()->json([
            'dayList' => DayListResource::collection(DayList::all()),
            'services' => BusinessServiceResource::collection($business->services),
            'appointmentRanges' => AppointmentRangeResource::collection(AppointmentRange::all()),
            'rates' => $rates,
            'productRate' => $product_rates,
            'genders' => BusinnessType::all(),
        ]);
    }

    /**
     * Personel Ekle
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonalAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $personel = new Personel();
        $personel->business_id = $business->id;
        $personel->name = $request->input('name');
        $personel->image = "business/team.png";
        $personel->email = $request->email;
        $personel->password = Hash::make($request->password);
        $personel->phone = $request->phone;
        $personel->accepted_type = $request->approveType;
        $personel->accept = $request->accept;
        $personel->start_time = $request->startTime;
        $personel->end_time = $request->endTime;
        $personel->food_start = $request->foodStart;
        $personel->food_end = $request->foodEnd;
        $personel->gender = $business->type->id == 3 ? $request->gender : $business->type->id;
        $personel->rate = $request->rate;
        $personel->product_rate =0; //$request->productRate;
        $personel->range = $request->appointmentRange;
        $personel->description = $request->description;

        $dayList = DayList::all();

        if ($request->hasFile('logo')) {
            $response = UploadFile::uploadFile($request->file('logo'), 'personel_images');
            $personel->image = $response["image"]["way"];
        }
        if ($personel->save()) {
            foreach ($dayList as $day) {
                $restDay = new PersonelRestDay();
                $restDay->personel_id = $personel->id;
                $restDay->day_id = $day->id;
                $restDay->status = in_array($day->id, explode(',', $request->restDay)) ? 1 : 0;
                $restDay->save();
            }
            if (in_array('all', explode(',', $request->services))) {
                foreach ($business->services as $service) {
                    $personelService = new PersonelService();
                    $personelService->service_id = $service->id;
                    $personelService->personel_id = $personel->id;
                    $personelService->save();
                }
            } else {
                foreach (explode(',', $request->services) as $service) {
                    $personelService = new PersonelService();
                    $personelService->service_id = $service;
                    $personelService->personel_id = $personel->id;
                    $personelService->save();
                }
            }
            return response()->json([
                'status' => "success",
                'message' => "Personel Eklendi",
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Personel Eklenirken Bir Hata Oluştu Lütfen Tekrar Deneyin",
        ]);
    }

    /**
     * Personel Detayı
     *
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function show(Personel $personel)
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $openedAppointments = $personel->appointments()->whereNotIn('status', [3, 4, 5])
            ->where('start_time', '>=', $oneMonthAgo)
            ->orderBy('start_time', 'desc')
            ->take(50)
            ->get();
        $completedAppointments = $personel->appointments()
            ->whereIn('status', [3, 4])->latest('start_time')
            ->orderBy('start_time', 'desc')
            ->take(50)
            ->get();
        $closedAppointments = $personel->appointments()
            ->where('status', 5)
            ->orderBy('start_time', 'desc')
            ->take(50)
            ->get();

        return response()->json([
            'openedAppointments' => PersonelAppointmentResource::collection($openedAppointments),
            'completedAppointments' => PersonelAppointmentResource::collection($completedAppointments),
            'closedAppointments' => PersonelAppointmentResource::collection($closedAppointments),
        ]);
    }

    /**
     * Personel Düzenle
     *
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function edit(Personel $personel)
    {
        return response()->json(PersonelResource::make($personel));
    }

    /**
     * Personel Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function update(PersonalUpdateRequest $request, Personel $personel)
    {
        $user = $request->user();
        $business = $user->business;

        $personel->name = $request->input('name');
        $personel->email = $request->email;
        if ($request->filled('password') && isset($request->password)) {
            $personel->password = Hash::make($request->password);
        }
        $personel->phone = $request->phone;
        $personel->accepted_type = $request->approveType;
        $personel->accept = $request->accept;
        $personel->start_time = $request->startTime;
        $personel->end_time = $request->endTime;
        $personel->food_start = $request->foodStart;
        $personel->food_end = $request->foodEnd;
        $personel->gender = $business->type->id == 3 ? $request->gender : $business->type->id;
        $personel->rate = $request->rate;
        $personel->range = $request->appointmentRange;
        $personel->description = $request->description;
        $personel->product_rate = 0;//$request->productRate;

        $dayList = DayList::all();

        if ($request->hasFile('logo')) {
            $response = UploadFile::uploadFile($request->file('logo'), 'personel_images');
            $personel->image = $response["image"]["way"];
        }
        if ($personel->save()) {
            foreach ($dayList as $day) {
                $restDay = new PersonelRestDay();
                $restDay->personel_id = $personel->id;
                $restDay->day_id = $day->id;
                $restDay->status = in_array($day->id, explode(',', $request->restDay)) ? 1 : 0;
                $restDay->save();
            }
            if (in_array('all', explode(',', $request->services))) {
                foreach ($business->services as $service) {
                    $personelService = new PersonelService();
                    $personelService->service_id = $service->id;
                    $personelService->personel_id = $personel->id;
                    $personelService->save();
                }
            } else {
                foreach (explode(',', $request->services) as $service) {
                    $personelService = new PersonelService();
                    $personelService->service_id = $service;
                    $personelService->personel_id = $personel->id;
                    $personelService->save();
                }
            }
            return response()->json([
                'status' => "success",
                'message' => "Personel Bilgileri Güncellendi",
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Personel Eklenirken Bir Hata Oluştu Lütfen Tekrar Deneyin",
        ]);
    }

    /**
     * Personel Sil
     *
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personel $personel)
    {
        if ($personel) {
            $personel->delete();
            return response()->json([
                'status' => "success",
                'message' => "Personel Silindi",
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Personel Bulunamadı",
        ]);
    }

    /**
     * Personel Bildirim
     *
     * örnek : {
     * "title": "Test Bildirimi app",
     * "message": "Test Bildirimi app içerik",
     * "personelIds": [2,3,5]
     * }
     *
     * @return \Illuminate\Http\Response
     */
    public function sendNotify(PersonelNotificationAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;
        $lastNotify = $business->personelNotifications()->latest()->first();

        if (now()->diffInMinutes($lastNotify->created_at) < 3) {
            return response()->json([
                'status' => "error",
                'message' => "Toplu Bildirimleri 3 Dakikada Bir Gönderebilirsiniz",
            ]);
        } else {
            if (count($request->personelIds) > 0) {
                foreach ($request->personelIds as $personelId) {
                    $personelNotification = new PersonelNotification();
                    $personelNotification->title = $request->title;
                    $personelNotification->message = $request->message;
                    $personelNotification->personel_id = $personelId;
                    $personelNotification->business_id = $business->id;
                    $personelNotification->link = uniqid(20);
                    $personelNotification->save();
                }

                return response()->json([
                    'status' => "success",
                    'message' => "Personellere Bildirim Gönderildi",
                ]);
            } else {
                return response()->json([
                    'status' => "error",
                    'message' => "Lütfen Personel Seçiniz",
                ]);
            }
        }

    }

    /**
     * Kasa Yetkisi Ata
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function setCase(Personel $personel)
    {
        if ($personel->safe == 1) {
            $personel->safe = 0;
            if ($personel->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Personelden Kasa Yetkisi Alındı",
                ]);
            }
        } else {
            $personel->safe = 1;
            if ($personel->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Personele Kasa Yetkisi Verildi",
                ]);
            }
        }
    }

    /**
     * Personel Kasası
     *
     * listType değişkeninde gönderilecek
     * <ul>
     *     <li>yesterday</li>
     *     <li>thisWeek</li>
     *     <li>thisMonth</li>
     * </ul>
     * @param Personel $personel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function case(Personel $personel, Request $request)
    {
        $appoinments = $personel->appointments()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('start_time', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('start_time', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('start_time', now()->subDays(1)->toDateString());
            }
        })->get();
        $servicePrice = 0;
        foreach ($appoinments as $appointment) {
            $servicePrice += $appointment->service->price;
        }
        $hizmetHakedis = ($servicePrice * $personel->rate) / 100;
        $productPrice = $personel->sales()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('created_at', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('created_at', now()->subDays(1)->toDateString());
            }
        })->sum('total');

        $urunHakedis = (($productPrice * $personel->product_rate) / 100);

        return response()->json([
            'totalCiro' => number_format($servicePrice + $productPrice, 2),
            'progressPayment' => number_format($hizmetHakedis + $urunHakedis, 2),
            'balanceInside' => number_format(($hizmetHakedis + $urunHakedis) - $this->calculatePayedBalance($personel)->sum('price'),  2),
            'balancePayed' => number_format($this->calculatePayedBalance($personel)->sum('price'), 2),
            'payments' => MaasListResource::collection($this->calculatePayedBalance($personel)),
        ]);
    }

    public function totalBalance($personel)
    {
        $productPrice = $personel->sales->sum('total');
        $servicePrice = 0;
        foreach ($personel->appointments as $appointment) {
            $servicePrice += $appointment->service->price;
        }
        $hizmetHakedis = ($servicePrice * $personel->rate) / 100;
        $urunHakedis = (($productPrice * $personel->product_rate) / 100);

        return $hizmetHakedis + $urunHakedis;
    }

    public function calculatePayedBalance($personel)
    {
        $costs = $personel->costs()
            //->where('cost_category_id', 1)
            ->get();
        return $costs;
    }
}
