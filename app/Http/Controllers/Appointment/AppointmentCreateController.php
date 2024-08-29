<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentCreateRequest;
use App\Http\Requests\Appointment\AppointmentSummaryRequest;
use App\Http\Requests\Appointment\GetClockRequest;
use App\Http\Requests\Appointment\PersonelDateGetRequest;
use App\Http\Requests\Appointment\ServicePersonelGetRequest;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Customer\CustomerListResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinessService;
use App\Models\Campaign;
use App\Models\Personel;
use App\Models\PersonelRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group AppointmentCreate
 *
 */
class AppointmentCreateController extends Controller
{
    /**
     *
     * Hizmet Listesi
     * @param Request $request
     * @return void
     */
    public function getService(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        $womanServicesArray = $business->services()->where('type', 1)->with('categorys')->get();
        $womanServiceCategories = $womanServicesArray->groupBy('categorys.name');
        $womanServices = $this->transformServices($womanServiceCategories);

        $manServicesArray = $business->services()->where('type', 2)->with('categorys')->get();
        $manServiceCategories = $manServicesArray->groupBy('categorys.name');
        $manServices = $this->transformServices($manServiceCategories);

        /*$unisexServicesArray = $business->services()->where('type', 3)->with('categorys')->get();
        $unisexServiceCategories = $unisexServicesArray->groupBy('categorys.name');
        $unisexServices = $this->transformServices($unisexServiceCategories);*/

        return response()->json([
           'business_type' => $business->type_id,
           'womanCategories' => $womanServices,
           'manCategories' => $manServices,
        ]);
    }
    /**
     *
     * Personel Listesi
     * @param Request $request
     * @return void
     */
    public function getPersonel(ServicePersonelGetRequest $request)
    {
        $user = $request->user();
        $business = $user->business;
        $getData = $request->serviceIds;
        $room_id = $request->room_id;
        $rooms = [];
        if ($business->rooms->count() > 0) {
            $rooms[] = [
                "id" => 0,
                "name" => "Salon",
                "color" => "#000",
                "percentage" => 0,
            ];
            foreach ($business->rooms as $room) {
                $rooms[] = [
                    "id" => $room->id,
                    "name" => $room->name,
                    "color" => $room->color,
                    "percentage" => $room->price,
                ];
            }
        }
        $ap_services = [];
        foreach ($getData as $id) {
            $service = BusinessService::find($id);
            $servicePersonels = [];
            foreach ($service->personels as $item) {
                if ($item->personel && $item->personel->status == 1) {
                    if ($business->rooms->count() > 0 && isset($room_id)) {
                        $roomPersonelIds = PersonelRoom::where('business_id', $item->personel->business_id)
                            ->where('room_id', $room_id)
                            ->pluck('personel_id')
                            ->toArray();

                        if (in_array($item->personel_id, $roomPersonelIds)) {
                            $servicePersonels[] = [
                                'id' => $item->personel->id,
                                'merged_id' => $item->personel?->id . "_" . $service->id,
                                'name' => $item->personel?->name,
                            ];
                        }
                    } else {
                        $servicePersonels[] = [
                            'id' => $item->personel->id,
                            'merged_id' => $item->personel?->id . "_" . $service->id,
                            'name' => $item->personel?->name,
                        ];
                    }

                }
            }

            $ap_services[] = [
                'id' => $id,
                'title' => $service->subCategory->getName() . " için personel seçiniz",
                'personels' => $servicePersonels,
            ];
        }
        return response()->json([
            'rooms' => $rooms,
            'personels' => $ap_services,

        ]);
    }
    /**
     *
     * Müşteri Listesi
     * @param Request $request
     * @return void
     */
    public function getCustomer(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $customers = $business->customers()->whereHas('customer', function ($q) use ($request) {
            $name = strtolower($request->input('name'));
            $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
        })->take(20)->get();
        return response()->json(CustomerListResource::collection($customers));
    }
    /**
     *
     * Tarih Listesi
     * @param Request $request
     * @return void
     */
    public function getDate()
    {
        $i = 0;
        $remainingDate = [];

        while ($i <= 30) {
            $remainingDate[] = Carbon::now()->addDays($i);
            $i++;
        }

        foreach ($remainingDate as $date) {
            $dateStartOfDay = clone $date;
            $dateStartOfDay->startOfDay();

            $today = Carbon::now()->startOfDay();
            $tomorrow = Carbon::now()->addDays(1)->startOfDay();

            if ($dateStartOfDay->eq($today)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Bugün",
                    'month' => $date->translatedFormat('F'),
                    'text' => "Bugün",
                    'value' => $date->toDateString(),
                ];
            } else if ($dateStartOfDay->eq($tomorrow)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Yarın",
                    'text' => "Yarın",
                    'month' => $date->translatedFormat('F'),
                    'value' => $date->toDateString(),
                ];
            } else {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'month' => $date->translatedFormat('F'),
                    'day' => $date->translatedFormat('l'),
                    'text' => $date->translatedFormat('d F l'),
                    'value' => $date->toDateString(),
                ];
            }
        }

        return response()->json($dates);
    }

    /**
     * Saat Listesi
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getClock(Request $request, Business $business)
    {
        $getDate = Carbon::parse($request->appointment_date);
        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personels as $personelId) {
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }
        $uniquePersonals = array_unique($personelIds);

        // personelleri gelen id lere göre db den collection olarak al
        $personels = [];
        foreach ($uniquePersonals as $id) {
            $personels[] = Personel::find($id);
        }
        $clocks = [];
        if (count($uniquePersonals) == 1) {
            foreach ($personels as $personel) {

                $disabledDays[] = $this->findTimes($personel, $request->room_id);
                //işletme kapalı gün kontrolü
                if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                    return response()->json([
                        "status" => "error",
                        "message" => "İşletme bu tarihte hizmet vermemektedir"
                    ], 200);
                } else {
                    //işletme kapalı değilse personel izin kontrolü
                    if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                        return response()->json([
                            "status" => "error",
                            "message" => "Personel bu tarihte hizmet vermemektedir"
                        ], 200);
                    } else {
                        //personel kapalı değilse personel izin gün kontrolü
                        if ($personel->checkDateIsOff($getDate)) {
                            return response()->json([
                                "status" => "error",
                                "message" => "Personel bu tarihte hizmet vermemektedir"
                            ], 200);
                        } else {
                            //tüm koşullar sağlanmış ise personel saat takvimi
                            $checkCustomWorkTime = $personel->isCustomWorkTime($request->appointment_date);

                            if (isset($checkCustomWorkTime)) {
                                if (Carbon::parse($checkCustomWorkTime->start_time) < Carbon::parse($checkCustomWorkTime->end_time)) {
                                    for ($i = Carbon::parse($checkCustomWorkTime->start_time); $i < Carbon::parse($checkCustomWorkTime->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }
                                } else {
                                    $lastTime = "";
                                    for ($i = Carbon::parse($checkCustomWorkTime->start_time); $i < Carbon::parse($checkCustomWorkTime->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                        $lastTime = $i->format('H:i');
                                    }

                                    $newStartTime = $getDate->addDays(1);

                                    for ($i = $newStartTime; $i < Carbon::parse($newStartTime->toDateString() . $checkCustomWorkTime->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $i->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $i->format('d.m.Y'),
                                            'value' => $i->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($i->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }

                                }

                            } else {
                                if (Carbon::parse($personel->start_time) < Carbon::parse($personel->end_time)) {
                                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }
                                } else {
                                    $lastTime = "";
                                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time)->endOfDay(); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                            'saat' => $i->format('H:i'),
                                            'date' => $getDate->format('d.m.Y'),
                                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                        $lastTime = $i->format('H:i');
                                    }

                                    $newStartTime = $getDate->addDays(1);

                                    for ($i = $newStartTime; $i < Carbon::parse($newStartTime->toDateString() . $personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                        $clocks[] = [
                                            'id' => $i->format('d_m_Y_H_i'),
                                            'saat' => $i->format('H:i'),
                                            'date' => $i->format('d.m.Y'),
                                            'value' => $i->format('d.m.Y H:i'),
                                            'durum' => in_array($i->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                        ];
                                    }

                                }

                            }


                        }

                    }
                }


            }
        } else { // birden fazla ve farklı personel seçilmişse

            if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                return response()->json([
                    "status" => "error",
                    "message" => "İşletme bu tarihte hizmet vermemektedir"
                ], 200);
            } else {
                // işletme çalışma saatlerine randevu aralığına göre diziye ekle
                foreach ($personels as $personel) {
                    $disabledDays = [];
                    $disabledDays[] = $this->findTimes($personel, $request->room_id);
                    //işletme kapalı gün kontrolü
                    if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                        return response()->json([
                            "status" => "error",
                            "message" => "İşletme bu tarihte hizmet vermemektedir"
                        ], 200);
                    } else {
                        //işletme kapalı değilse personel izin kontrolü
                        if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                            return response()->json([
                                "status" => "error",
                                "message" => "Personel ".$personel->name." bu tarihte hizmet vermemektedir"
                            ], 200);
                        } else {
                            //personel kapalı değilse personel izin gün kontrolü
                            if ($personel->checkDateIsOff($getDate)) {
                                return response()->json([
                                    "status" => "error",
                                    "message" => "Personel ".$personel->name." bu tarihte hizmet vermemektedir"
                                ], 200);
                            } else {
                                for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                                    $clocks[] = [
                                        'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                        'saat' => $i->format('H:i'),
                                        'date' => $getDate->format('d.m.Y'),
                                        'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                                        'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                                    ];
                                }

                            }

                        }
                    }



                }
                // Value değerlerine göre gruplandır
                $groupedValues = [];
                foreach ($clocks as $item) {
                    $value = $item['value'];
                    if (!isset($groupedValues[$value])) {
                        $groupedValues[$value] = [];
                    }
                    $groupedValues[$value][] = $item['durum'];
                }

                // Tüm personllerin dizide durum değeri true olan value değerlerini topla
                $totalClocks = [];
                foreach ($groupedValues as $value => $statuses) {
                    if (count($statuses) > 1 && !in_array(false, $statuses)) {
                        $totalClocks[] = $value;
                    }
                }

                $clocks = [];

                $appStartTime = Carbon::parse($totalClocks[0]);
                $endTime = Carbon::parse($totalClocks[count($totalClocks) - 1]);

                $clockRange = $appStartTime->diffInMinutes($endTime);
                $totalServiceTime = 0;

                foreach ($serviceIds as $index => $serviceId) {
                    $service = BusinessService::find($serviceId);
                    $totalServiceTime += $service->time;
                }
                if ($clockRange < $totalServiceTime){
                    return response()->json([
                        "status" => "error",
                        "message" => "Seçtiğiniz Hizmetlere Uygun Randevu Aralığı Bulunamadı"
                    ], 200);
                }
                foreach ($totalClocks as $clock){
                    $parsedClock = Carbon::parse($clock);
                    $clocks[] = [
                        'id' => $parsedClock->format('d_m_Y_' . $parsedClock->format('H_i')),
                        'saat' => $parsedClock->format('H:i'),
                        'date' => $parsedClock->format('d.m.Y'),
                        'value' => $parsedClock->format('d.m.Y ' . $parsedClock->format('H:i')),
                        'durum' => true
                    ];
                }


            }
        }
        return response()->json($clocks);


    }

    /**
     *
     * Randevu Özeti
     * @param Request $request
     * @return void
     */
    public function summary(AppointmentSummaryRequest $request)
    {
        $user = $request->user();
        $business = $user->business;
        $customer = $business->customers()->where('customer_id', $request->customer_id)->first();
        $businessServices = $business->services()->whereIn('id', $request->services)->get();

        return response()->json([
            'customer' => CustomerListResource::make($customer),
            'appointmentDate' => $request->times[0],
            'services' => BusinessServiceResource::collection($businessServices),
            'total' => $businessServices->sum('price'),
        ]);
    }

    public function findTimes($personel)
    {
        $disableds = [];

        $appointments = $personel->appointments()->whereNotIn('status', [3])->get();

        foreach ($appointments as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime <= $endDateTime) {

                $disableds[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->range));
            }
        }

        return $disableds;
    }

    /**
     *
     * Randevu Oluştur
     * @param Request $request
     * @return JsonResponse
     */
    public function appointmentCreate(AppointmentCreateRequest $request)
    {
        $user = $request->user();
        $business = $user->business;
        $appointment = new Appointment();
        $appointment->customer_id = $request->customer_id;
        $appointment->business_id = $business->id;
        $appointment->room_id = $request->room_id == 0 ? null : $request->room_id;
        $appointment->save();

        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personels as $personelId) {
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }

        $appointmentStartTime = Carbon::parse($request->appointment_time);
        $approve_types = [];
        foreach ($serviceIds as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $personelIds[$index];
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time);
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->save();

            $approve_types[] = $findService->approve_type;

        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
        $calculateTotal = $appointment->calculateTotal();
        $appointment->total = $calculateTotal;
        if (in_array(1, $approve_types)) { // hizmet maneul onay ise
            $appointment->status = 0; // Otomatik onay
            foreach ($appointment->services as $service) {
                $service->status = 0;
                $service->save();
            }
            $message = $business->name . " İşletmesine Randevunuz talebiniz alınmıştır. İşletmemiz en kısa sürede sizi bilgilendirecektir.";

        } else {
            $appointment->status = 1; // Otomatik onay ise
            foreach ($appointment->services as $service) {
                $service->status = 1;
                $service->save();
            }
            $message = $business->name . " İşletmesine " . $appointment->start_time->format('d.m.Y H:i') . " tarihine randevunuz oluşturuldu.";

        }
        if ($appointment->save()) {
            if (isset($request->campaign_id)){
                $campaign = Campaign::find($request->campaign_id);
                $discount = $campaign->discount;
                $appointment->campaign_id = $request->campaign_id;
                $appointment->discount = $discount;
                $appointment->save();
            }
            //$appointment->customer->sendSms($message);
            $title = "Randevunuz Oluşturuldu";
            $appointment->customer->sendNotification($title, $message);
            $appointment->sendPersonelNotification();
            $appointment->scheduleReminder();
            $appointment->calculateTotal();
            return response()->json([
                'status' => "success",
                'message' => "Randevunuz başarılı bir şekilde oluşturuldu",
                'appointment' => AppointmentResource::make($appointment),
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Bir hata sebebiyle randevunuz oluşturulamadı lütfen tekrar deneyiniz",
        ], 422);
    }



    function transformServices($womanServiceCategories){
        $transformedDataWoman = [];
        foreach ($womanServiceCategories as $category => $services) {

            $transformedServices = [];
            foreach ($services as $service) {
                if ($service->personels->count() > 0){
                    $transformedServices[] = [
                        'id' => $service->id,
                        'name' => $service->subCategory->getName(),
                        'price' => $service->price,
                    ];
                }
            }
            $transformedDataWoman[] = [
                'id' => $services->first()->category,
                'name' => $category,
                'services' => $transformedServices,
            ];
        }
        return $transformedDataWoman;
    }
}
