<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentCreateRequest;
use App\Http\Requests\Appointment\AppointmentSummaryRequest;
use App\Http\Requests\Appointment\PersonelDateGetRequest;
use App\Http\Requests\Appointment\ServicePersonelGetRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Customer\CustomerListResource;
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
        $salonTypes = [
            [
                'id' => 1,
                'name' => "Vip Salon"
            ],
            [
                'id' => 1,
                'name' => "Normal Salon"
            ],
        ];

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
                'salonType' => $salonTypes,
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

    public function getClock(Request $request)
    {
        $getDate = Carbon::parse($request->date);
        $business = $request->user()->business;
        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personelIds as $personelId){
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

                $disabledDays[] = $this->findTimes($personel);

                if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                    $clocks[] = [
                        'id' => $getDate->format('d_m_Y_'),
                        'saat' => 'İşletme bu tarihte hizmet vermemektedir',
                        'date' => $getDate->format('d.m.Y'),
                        'value' => $getDate->format('d.m.Y '),
                        'durum' => false,
                    ];
                    return response()->json([
                        "status" => "error",
                        "message" => "İşletme bu tarihte hizmet vermemektedir"
                    ], 422);
                } else {
                    if (in_array(Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek, $personel->restDays()->pluck('day_id')->toArray())) {
                        $clocks[] = [
                            'id' => $getDate->format('d_m_Y_'),
                            'saat' => 'Personel bu tarihte hizmet vermemektedir',
                            'date' => $getDate->format('d.m.Y'),
                            'value' => $getDate->format('d.m.Y '),
                            'durum' => false,
                        ];
                        return response()->json([
                            "status" => "error",
                            "message" => "Personel bu tarihte hizmet vermemektedir"
                        ], 422);
                    } else {
                        if ($personel->checkDateIsOff($getDate)) {
                            $clocks[] = [
                                'id' => $getDate->format('d_m_Y_'),
                                'saat' => 'Personel ' . Carbon::parse($personel->stayOffDays->start_time)->format('d.m.Y H:i') . " tarihinden " . Carbon::parse($personel->stayOffDays->end_time)->format('d.m.Y H:i') . " Tarihine Kadar İzinlidir",
                                'date' => $getDate->format('d.m.Y'),
                                'value' => $getDate->format('d.m.Y '),
                                'durum' => false,
                            ];
                            return response()->json([
                                "status" => "error",
                                "message" => 'Personel ' . Carbon::parse($personel->stayOffDays->start_time)->format('d.m.Y H:i') . " tarihinden " . Carbon::parse($personel->stayOffDays->end_time)->format('d.m.Y H:i') . " Tarihine Kadar İzinlidir",
                            ], 422);
                        } else {
                            for ($i = \Illuminate\Support\Carbon::parse($personel->start_time); $i < \Illuminate\Support\Carbon::parse($personel->end_time); $i->addMinute($personel->range)) {
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

        } else { // birden fazla ve farklı personel seçilmişse

            if (Carbon::parse($getDate->format('d.m.Y'))->dayOfWeek == $business->off_day) {
                $clocks[] = [
                    'id' => $getDate->format('d_m_Y_'),
                    'saat' => 'İşletme bu tarihte hizmet vermemektedir',
                    'date' => $getDate->format('d.m.Y'),
                    'value' => $getDate->format('d.m.Y '),
                    'durum' => false,
                ];
                return response()->json([
                    "status" => "error",
                    "message" => "İşletme bu tarihte hizmet vermemektedir"
                ], 422);
            } else {
                // işletme çalışma saatlerine randevu aralığına göre diziye ekle
                $businessClocks = [];
                for ($i = \Illuminate\Support\Carbon::parse($business->start_time); $i < \Illuminate\Support\Carbon::parse($business->end_time); $i->addMinute($business->appoinment_range)) {
                    $businessClocks[] = $getDate->format('d.m.Y ' . $i->format('H:i'));
                }
                // personellerin dolu saatlerini bul
                $disabledClocks = [];
                foreach ($personels as $personel) {
                    $disabledClocks[] = $this->findTimes($personel);
                }
                // diziyi tek boyuta düşür
                $flattenedArray = [];
                foreach ($disabledClocks as $subArray) {
                    $flattenedArray = array_merge($flattenedArray, $subArray);
                }
                // dizi deki aynı olan verileri kaldır
                $disabledTimes = array_unique($flattenedArray);

                // hizmetlerin sürelerini al ve toplam süreye ekle
                $totalMinute = 0;
                foreach ($serviceIds as $serviceId) {
                    $service = BusinessService::find($serviceId);
                    $totalMinute += $service->time;
                }
                $totalMinutes = $totalMinute;

                foreach ($businessClocks as $index => $clock) {

                    $i = Carbon::parse($clock);
                    $clocks[] = array(
                        'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                        'saat' => $i->format('H:i'),
                        'date' => $getDate->format('d.m.Y'),
                        'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                        // işletmenin çalışma saatleri ile personelin çalışma saatlerini karşılaştır aynı olanları false yap
                        'durum' => !in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledTimes),
                    );
                }
                $found = false;
                $startTime = null;
                $currentTime = null;
                $totalTime = 0;
                foreach ($clocks as $clock) {
                    if ($clock['durum']) {
                        if ($currentTime === null) {
                            $currentTime = Carbon::parse($clock['value']);
                            $startTime = $currentTime;
                        } else {
                            $nextTime = Carbon::parse($clock['value']);
                            $timeDifference = $nextTime->diffInMinutes($currentTime);
                            $totalTime += $timeDifference;

                            // Eğer toplam süre  60 dakika veya daha fazla ise, durumu false olarak ayarla
                            if ($totalTime >= $totalMinutes) {
                                $found = true;
                                break;
                            }

                            $currentTime = $nextTime;
                        }
                    } else {
                        $currentTime = null;
                        $totalTime = 0; // Boş alan başladığında toplam süreyi sıfırlayın
                    }
                }

                if (!$found) {
                    return response()->json([
                        "status" => "error",
                        "message" => "Seçtiğiniz Hizmetler için uygun randevu aralığı bulunmamaktadır. Personeli veya Hizmeti Değiştirerek Yeniden Saat Arayabilirsiniz."
                    ],422);
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

        $personelIds = [];
        $serviceIds = [];
        foreach ($request->personels as $personelId){
            $personelIds[] = explode('_', $personelId)[0];
            $serviceIds[] = explode('_', $personelId)[1];
        }

        $appointmentStartTime = Carbon::parse($request->times[0]);
        foreach ($serviceIds as $index => $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $personelIds[$index];
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime->format('d.m.Y H:i');
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time)->format('d.m.Y H:i');
            $appointmentService->appointment_id = $appointment->id;
            $appointmentService->save();
        }

        $appointment->start_time = $appointment->services()->first()->start_time;
        $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
        $appointment->total = $request->total;
        $appointment->discount = $request->discountTotal;

        if ($appointment->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Randevunuz " . $appointment->start_time . " - " . $appointment->end_time . " arasına randevunuz oluşturuldu",
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Bir hata sebebiyle randevunuz oluşturulamadı lütfen tekrar deneyiniz"
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
