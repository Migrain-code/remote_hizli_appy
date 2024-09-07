<?php

namespace App\Http\Controllers\CloseClock;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentCreateRequest;
use App\Http\Requests\Customer\CustomerSearchRequest;
use App\Http\Requests\PersonelAccount\SpeedAppointment\AddCustomerRequest;
use App\Http\Requests\PersonelAccount\SpeedAppointment\CheckPersonelClockRequest;
use App\Http\Requests\PersonelAccount\SpeedAppointment\GetPersonelClockRequest;
use App\Http\Requests\PersonelAccount\SpeedAppointment\SpeedAppointmentCreateRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Personel\PersonelServiceResource;
use App\Http\Resources\PersonelAccount\Rooms\RoomsListResource;
use App\Http\Resources\PersonelAccount\SpeedAppointment\PersonelAppointmentServiceResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\BusinessCustomer;
use App\Models\BusinessService;
use App\Models\Customer;
use App\Models\CustomerNotificationPermission;
use App\Models\Personel;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @group Saat Kapatma
 */
class SpeedAppointmentController extends Controller
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
     * Personel Listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $personels = $this->business->personels;
        return response()->json(PersonelListResource::collection($personels));
    }

    /**
     *  Müşteri Ekle
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function newCustomer(AddCustomerRequest $request)
    {
        $phone = clearPhone($request->input('phone'));
        if (strlen($phone) != 11) {
            return response()->json([
                'status' => "error",
                'message' => "Lütfen Telefon Numarasını 11 Haneli olarak giriş yapın"
            ], 422);
        }
        if ($this->existPhone($phone)) {
            return response()->json([
                'status' => "error",
                'message' => "Bu telefon numarası ile kayıtlı müşteri bulunuyor lütfen başka bir numara giriniz"
            ], 422);
        }
        $generatePassword = rand(100000, 999999);
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->phone = clearPhone($request->input('phone'));
        $customer->password = Hash::make($generatePassword);
        $customer->status = 1;
        $customer->verify_phone = 1;
        if ($customer->save()) {
            $message = "Merhaba " . $customer->name . ", Hızlı Randevu'ya hoş geldiniz! Giriş Bilgileriniz: Tel: " . $customer->phone . ", Şifre: " . $generatePassword . ". İyi günler , Hızlı Randevu";

            Sms::send($customer->phone, $message);
            $this->addPermission($customer->id);
            $this->addBusinessCustomerList($customer->id);
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Başarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    /**
     * Müşteri Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerList(CustomerSearchRequest $request)
    {
        $customers = $this->business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
                });
            })
            /*->take(30)*/->get();
        return response()->json(CustomerListResource::collection($customers));
    }

    /**
     * Personel Hizmet ve Oda Listesi
     *
     * @param Personel $personel
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPersonelServiceList(Personel $personel)
    {
        $services = $personel->services;
        $roomCount = $personel->rooms->count();
        if ($roomCount > 1){
            $rooms = $personel->rooms;
        } else{
            $rooms = collect([]);
        }
        dd($rooms);
        return response()->json([
            'services' => PersonelAppointmentServiceResource::collection($services),
            'rooms' => RoomsListResource::collection($rooms),
        ]);
    }

    /**
     * Personel Saat Listesi
     *
     * @param Personel $personel
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function getPersonelClocks(Personel $personel, GetPersonelClockRequest $request)
    {
        $getDate = Carbon::parse($request->appointment_date);

        $disabledDays[] = $this->findTimes($personel, $getDate);
        $business = $this->business;
        $clocks = [];
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
                    for ($i = Carbon::parse($personel->start_time); $i < Carbon::parse($personel->end_time); $i->addMinute($personel->appointmentRange->time)) {
                        if (!in_array($getDate->format('d.m.Y ') . $i->format('H:i'), $disabledDays[0])) {
                            $clocks[] = [
                                'id' => $getDate->format('d_m_Y_' . $i->format('H_i')),
                                'saat' => $i->format('H:i'),
                                'date' => $getDate->format('d.m.Y'),
                                'value' => $getDate->format('d.m.Y ' . $i->format('H:i')),
                            ];
                        }
                    }


                }

            }
        }
        if (count($clocks)  > 0){
            return $clocks;
        } else{
            return response()->json([
               'status' => "error",
               'message' => "Personelin Bugünkü Tüm Saatleri Dolu. Lütfen Başka bir tarih seçiniz"
            ], 200);
        }
    }

    /**
     * Randevu Oluştur
     *
     * @param Personel $personel
     * @param SpeedAppointmentCreateRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function appointmentCreate(Personel $personel, SpeedAppointmentCreateRequest $request)
    {
        $business = $this->business;
        $roomId = null;
        if ($personel->rooms->count() == 1){
            $roomId = $personel->rooms->first()->room_id;
        } else{
            if ($business->activeRooms->count() > 0){
                $roomId = $request->room_id;
                if (!isset($roomId)){
                    return response()->json([
                        'status' => "error",
                        'message' => "Oda Seçimi Alanı Gereklidir"
                    ], 422);
                }
            }

        }
        if ($request->appointment_type != "closeClock") {
            $result = $this->checkClock($personel, $request->start_time, $request->service_id, $roomId);
            if ($result["status"] == "error"){
                return response()->json($result, 422);
            }
        }
        $appointment = new Appointment();
        $appointment->customer_id = $request->customer_id;
        $appointment->business_id = $business->id;
        $appointment->room_id = $roomId;
        $appointment->save();


            $appointmentStartTime = Carbon::parse($request->start_time);
            foreach ($request->service_id as $serviceId) {
                $findService = BusinessService::find($serviceId);
                $appointmentService = new AppointmentServices();
                $appointmentService->personel_id = $personel->id;
                $appointmentService->service_id = $serviceId;
                $appointmentService->start_time = $appointmentStartTime->toDateTimeString();
                $appointmentService->appointment_id = $appointment->id;
                if ($request->appointment_type == "closeClock") { // saat kapatma ise
                    $appointmentService->end_time = Carbon::parse($request->end_time)->toDateTimeString();
                    if ($appointmentService->start_time >= $appointmentService->end_time) {
                        $appointment->delete();
                        $appointment->services()->delete();
                        return response()->json([
                            'status' => "error",
                            'message' => "Başlangıç saati bitiş saatinden küçük olmalıdır",
                        ], 422);
                    }
                    $result = $this->checkPersonelClock($personel->id, $appointmentService->start_time, $appointmentService->end_time);

                    if ($result) {
                        $appointment->services()->delete();
                        $appointment->delete();
                        return response()->json([
                            'status' => "error",
                            'message' => "Seçmiş olduğunuz saat aralığında randevu bulunmaktadır."
                        ], 422);
                    } else {
                        $appointmentService->save();
                    }
                } else {
                    $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time)->toDateTimeString();
                    $appointmentService->save();
                }

            }

            $appointment->start_time = $appointment->services()->first()->start_time;
            $appointment->end_time = $appointment->services()->skip($appointment->services()->count() - 1)->first()->end_time;
            $calculateTotal = $appointment->calculateTotal();
            $appointment->total = $calculateTotal;

            if ($business->approve_type == 1 && $request->appointment_type == "closeClock") {// Manuel onay ve saat kapatma ise
                $appointment->status = 0; // Onay bekliyor durumu
                foreach ($appointment->services as $service) {
                    $service->status = 0;
                    $service->save();
                }
            } else {
                $appointment->status = 2; // tamamlandı durumu

                foreach ($appointment->services as $service) {
                    $service->status = 2;
                    $service->save();
                }
            }

        $appointment->location = "Hızlı Randevu Patron Mobil Saat Kapatma Ve Adisyon Alanı";

        if ($appointment->save()) {
            $title = "Randevunuz başarılı bir şekilde oluşturuldu";
            $message = $business->name . " İşletmesine " . $appointment->start_time->format('d.m.Y H:i') . " tarihine randevunuz oluşturuldu.";
            //$appointment->customer->sendSms($message);

            $appointment->customer->sendNotification($title, $message);
            $appointment->scheduleReminder();
            return response()->json([
                'status' => "success",
                'message' => "Randevunuz başarılı bir şekilde oluşturuldu",
            ]);
        }
    }

    /**
     * Saat Kontrolü
     *
     * @urlParam start_time
     *
     * @param Request $request
     * @return string[]
     */
    public function checkClock($personel, $startTime, $serviceIds, $roomId = 0)
    {
        $appointmentStartTime = Carbon::parse($startTime);

        $appointmentId = rand(100000, 999999);

        foreach ($serviceIds as $serviceId) {
            $findService = BusinessService::find($serviceId);
            $appointmentService = new AppointmentServices();
            $appointmentService->personel_id = $personel->id;
            $appointmentService->service_id = $serviceId;
            $appointmentService->start_time = $appointmentStartTime;
            $appointmentService->end_time = $appointmentStartTime->addMinutes($findService->time)->toDateTimeString();
            $appointmentService->appointment_id = $appointmentId;
            //$appointmentService->save();
            /**------------------Saat Kontrolü------------------*/
            $result = $this->checkPersonelClock($personel->id, $appointmentService->start_time, $appointmentService->end_time, $roomId);

            if ($result) {
                return [
                    'status' => "error",
                    'message' => "Seçtiğiniz saate " . $findService->time . " dakikalık hizmet seçtiniz. Bu saate randevu alamazsınız. Başka bir saat seçmelisiniz."
                ];
            }
        }
        return [
            'status' => "success",
            'message' => "Saat seçim işleminiz onaylandı. Randevu Oluşturabilirsiniz"
        ];

    }
    public function checkPersonelClock($personelId, $startTime, $endTime)
    {
        $findPersonel = Personel::find($personelId);
        $disabledTimes = $this->findTimes($findPersonel, $startTime);

        $disableds = [];
        $currentDateTime = $startTime->copy();

        while ($currentDateTime < $endTime) {
            $disableds[] = $currentDateTime->format('d.m.Y H:i');
            $currentDateTime->addMinutes(intval($findPersonel->appointmentRange->time));
        }

        foreach ($disableds as $disabledTime) {
            if (in_array($disabledTime, $disabledTimes)) {
                return true;
            }
        }

        return false;
    }

    public function findTimes($personel, $appointment_date)
    {
        $disableds = [];

        // personelin dolu randevu saatlerini al iptal edilmişleri de dahil et
        $appointments = $personel->appointments()
            ->whereDate('start_time', Carbon::parse($appointment_date)->toDateString())
            ->whereNotIn('status', [3])->get();

        foreach ($appointments as $appointment) {
            $startDateTime = Carbon::parse($appointment->start_time);
            $endDateTime = Carbon::parse($appointment->end_time);

            $currentDateTime = $startDateTime->copy();
            while ($currentDateTime < $endDateTime) {

                $disableds[] = $currentDateTime->format('d.m.Y H:i');

                $currentDateTime->addMinutes(intval($personel->appointmentRange->time));
            }
        }

        // randevu almaya 30 dk öncesine kadar izin ver
        $startTime = Carbon::parse($personel->start_time);
        $endTime = Carbon::parse($personel->end_time);
        for ($i = $startTime; $i < $endTime; $i->addMinutes(intval($personel->appointmentRange->time))) {
            if ($i < now()->addMinutes(5)) {
                $disableds[] = $i->format('d.m.Y H:i');
            }
        }
        $business = $personel->business;
        if (isset($room_id) && $room_id > 0) {
            // oda tipi seçilmşse o odadaki randevuları al ve disabled dizisine ata
            $appointmentsBusiness = $business->appointments()->where('room_id', $room_id)->whereNotIn('status', [3])->get();
            foreach ($appointmentsBusiness as $appointment) {
                $businessStartDateTime = Carbon::parse($appointment->start_time);
                $businessEndDateTime = Carbon::parse($appointment->end_time);

                $businessCurrenDateTime = $businessStartDateTime->copy();
                while ($businessCurrenDateTime <= $businessEndDateTime) {

                    $disableds[] = $businessCurrenDateTime->format('d.m.Y H:i');

                    $businessCurrenDateTime->addMinutes(intval($business->range->time));
                }
            }
        }
        return $disableds;
    }

    public function existPhone($phone)
    {
        $existPhone = Customer::where('phone', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function addPermission($id)
    {
        $permission = new CustomerNotificationPermission();
        $permission->customer_id = $id;
        $permission->save();

        return $permission;
    }

    public function addBusinessCustomerList($id)
    {
        $businessCustomer = new BusinessCustomer();
        $businessCustomer->business_id = $this->business->id;
        $businessCustomer->customer_id = $id;
        $businessCustomer->type = 1;
        $businessCustomer->status = 1;
        $businessCustomer->save();
        return $businessCustomer;
    }
}
