<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\AppointmentCreateRequest;
use App\Http\Requests\Appointment\AppointmentSummaryRequest;
use App\Http\Requests\Appointment\ClockGetRequest;
use App\Http\Requests\Appointment\PersonelDateGetRequest;
use App\Http\Requests\Appointment\ServicePersonelGetRequest;
use App\Http\Resources\AppointmentPersonelResource;
use App\Http\Resources\BusinessServiceResource;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\PersonelListResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\BusinessService;
use App\Models\Personel;
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

        $unisexServicesArray = $business->services()->where('type', 3)->with('categorys')->get();
        $unisexServiceCategories = $unisexServicesArray->groupBy('categorys.name');
        $unisexServices = $this->transformServices($unisexServiceCategories);


        return response()->json([
           'womanCategories' => $womanServices,
           'manCategories' => $manServices,
           'unisexCategories' => $unisexServices,
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
        $getData = $request->serviceIds;

        $ap_services = [];
        foreach ($getData as $id) {
            $service = BusinessService::find($id);
            $servicePersonels = [];
            foreach ($service->personels as $item){
                if ($item->personel){
                    $servicePersonels[] = [
                        'id' => $item->personel?->id . "_" . $service->id,
                        'name' => $item->personel?->name,
                    ];
                }

            }


            $ap_services[] = [
                'id' => $id,
                'title' => $service->subCategory->getName() . " için personel seçiniz",
                'personels' => $servicePersonels,
            ];
        }
        return response()->json($ap_services);
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
        return response()->json(CustomerListResource::collection($business->customers));
    }
    /**
     *
     * Tarih Listesi
     * @param Request $request
     * @return void
     */
    public function getDate(PersonelDateGetRequest $request)
    {
        $personels = [];
        $getData = $request->personelIds;

        foreach ($getData as $personel_id) {
            $personels[] = Personel::find($personel_id);
        }
        $user = $request->user();
        $business = $user->business;

        $remainingDays = Carbon::now()->subDays(1)->diffInDays(Carbon::now()->copy()->endOfMonth());

        for ($i = 0; $i < $remainingDays; $i++) {
            $days = Carbon::now()->addDays($i);

            if ($days < Carbon::now()->endOfMonth()) {
                $remainingDate[] = $days;
            }
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
                    'text' => "Bugün",
                    'value' => $date,
                ];
            } else if ($dateStartOfDay->eq($tomorrow)) {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => "Yarın",
                    'text' => "Yarın",
                    'value' => $date,
                ];
            } else {
                $dates[] = [
                    'date' => $date->translatedFormat('d'),
                    'day' => $date->translatedFormat('l'),
                    'text' => $date->translatedFormat('d F l'),
                    'value' => $date,
                ];
            }
        }

        return response()->json([
            'dates' => $dates,
        ]);
    }
    /**
     *
     * Saat Listesi
     * @param Request $request
     * @return void
     */
    public function getClock(ClockGetRequest $request)
    {
        $getDate = Carbon::parse($request->date);
        $user = $request->user();
        $business = $user->business;
        $personelIds = [];
        foreach ($request->personelIds as $personelId){
            $personelIds[] = explode('_', $personelId)[0];
        }
        $uniqueArray = array_unique($personelIds);

        $personels = [];

        foreach ($uniqueArray as $id){

            $personels[]= Personel::find($id);
        }

        $newClocks=[];
        foreach ($personels as $personel){
            $clocks = [];
            $loop = 0;
            $disabledDays = [];
            $disabledDays[] = $this->findTimes($personel);
            for ($i = \Illuminate\Support\Carbon::parse($personel->start_time); $i < \Illuminate\Support\Carbon::parse($personel->end_time); $i->addMinute($personel->range)) {
                if (Carbon::parse($getDate->format('d.m.Y '))->dayOfWeek == $business->off_day) {
                    $clock = [
                        'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                        'saat' => 'İşletme Seçtiğiniz Gün Çalışmamaktadır.',
                        'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                        'durum' => false,
                    ];
                    if ($loop == 0) {
                        $clocks[] = $clock;
                    }

                    $loop++;

                } else {
                    if ($i->format('H:i') == $personel->food_start) {
                        for ($j = \Illuminate\Support\Carbon::parse($personel->food_start); $j < \Illuminate\Support\Carbon::parse($personel->food_end); $j->addMinute($personel->range)) {
                            $clock = [
                                'id' => $getDate->format('d_m_Y_' . $j->format('H_i')),
                                'saat' => $i->format('H:i'),
                                'value' => $getDate->format('d.m.Y ' . $j->format('H:i')),
                                'durum' => false,
                            ];
                            $clocks[] = $clock;
                        }
                    }
                    else{
                        $clock = [
                            'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                            'saat' => $i->format('H:i'),
                            'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                            'durum' => in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0]) ? false : true,
                        ];
                        $clocks[] = $clock;
                    }

                }
            }
            $newClocks[] = [
                'personel' => PersonelListResource::make($personel),
                'clocks' => $clocks,
            ];

        }

        return response()->json($newClocks);

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
            'appointmentDate' => $request->times[0][0],
            'services' => BusinessServiceResource::collection($businessServices),
            'total' => $businessServices->sum('price'),
        ]);
    }

    public function findTimes($personel)
    {
        $disableds = [];

        $appointments = $personel->appointments()->whereNotIn('status', [8])->get();

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
     * @return void
     */
    public function appointmentCreate(AppointmentCreateRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $appointment = new Appointment();
        $appointment->customer_id = $request->customer_id;
        $appointment->business_id = $business->id;

        if ($business->approve_type == 0) {
            $appointment->status = 1; // Otomatik onay
        } else {
            $appointment->status = 0; // Onay bekliyor
        }

        $appointment->save();

        $personels = $request->get('personels');
        $times = $request->get('times')[0];
        $services = $request->services;

        $loop = 0;
        $newTimes = [];

        foreach ($times as $time) {
            $personelId = $personels[$loop];
            $serviceId = $services[$loop];
            $findService = BusinessService::find($serviceId);

            $newTime = Carbon::parse($time)->format('d.m.Y H:i');
            $newTimes[] = $newTime;

            // Her bir hizmet için bir personel seçiliyor varsayalım
            $appointmentService = new AppointmentServices();
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->personel_id = $personelId;
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $newTime;
            $appointmentService->end_time = Carbon::parse($newTime)->addMinute($findService->time)->format('d.m.Y H:i');
            $appointmentService->save();

            $loop++;
        }

        // Diğer hizmetleri eklemek için ikinci bir döngü ekleyelim
        for ($i = $loop; $i < count($services); $i++) {
            $serviceId = $services[$i];
            $findService = BusinessService::find($serviceId);

            $newTime = Carbon::parse($times[$loop-1])->format('d.m.Y H:i');
            $newTimes[] = $newTime;


            // Her bir hizmet için bir personel seçiliyor varsayalım
            $appointmentService = new AppointmentServices();
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->personel_id = $personels[$loop]; // İlk personeli seçiyoruz, isteğe bağlı olarak farklı bir mantık uygulayabilirsiniz
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $newTime;
            $appointmentService->end_time = Carbon::parse($newTime)->addMinute($findService->time)->format('d.m.Y H:i');
            $appointmentService->save();
        }

        $appointment->start_time = $newTimes[0];
        $appointment->end_time = end($newTimes);
        $appointment->total = $request->total;
        $appointment->discount = $request->discountTotal;
        $appointment->note = $request->input('note');
        $appointment->save();

        // Push bildirimi eklenecek

        return response()->json([
            'status' => "success",
            'message' => "Randevu Başarılı Bir Şekilde Oluşturuldu"
        ]);
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