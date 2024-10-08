<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessInfo\BusinessInfoUpdateRequest;
use App\Http\Requests\Password\PasswordUpdateRequest;
use App\Http\Requests\Setup\DetailSetupRequestStep1;
use App\Http\Resources\Advert\AdvertListResource;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessOfficialResource;
use App\Http\Resources\Business\BusinessResource;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\PersonelAccount\Home\CustomerListResource;
use App\Http\Resources\Service\PersonelListResource;
use App\Models\Ads;
use App\Models\AppointmentRange;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @group Yönetici Anasayfa
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
    public function index()
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
        $personels = $this->business->personels;
        $advert = Ads::where('type', 12)->whereStatus(1)->first();

        return response()->json([
            'personels' => PersonelListResource::collection($personels),
            //'advert' => AdvertListResource::make($advert),
            'dates' => $dates,
            'is_notification' => $this->user->isNotificationStatus(), // true bildirim var false yok
        ]);
    }

    public function editorView()
    {
        $about = $this->business->about;
        return response()->json([
            'html' => view('editor', compact('about'))->render()
        ]);
    }

    public function editorUpdate(Request $request)
    {
        $business =  $this->business;
        $business->about = $request->get('about');
        $business->save();
        return response()->json([
           'status' => "success",
           'message' => "Hakkımızda Metni Güncellendi"
        ]);
    }
    /**
     * Today Apisi
     *
     */
    
    public function todayAppointment(Request $request)
    {
        $appointmentsSummary = $this->business->personels->map(function ($staffMember) use ($request) {
            $appointmentsForDate = $staffMember->appointments()
                ->when($request->filled('appointment_date'), function ($query) use ($request) {
                    $query->whereDate('start_time', Carbon::parse($request->appointment_date)->toDateString());
                })
                ->get()
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'start_time' => $appointment->start_time->format('H:i'),
                        'end_time' => $appointment->end_time->format('H:i'),
                        'services' => isset($appointment->service) ? $appointment->service->subCategory->name : "Hizmet silindi",
                        'customer' => $appointment->appointment->customer->name,
                        'status_color' => $appointment->status('color_code'),
                    ];
                });

            return [
                'personel' => new PersonelListResource($staffMember),
                'appointments' => $appointmentsForDate,
            ];
        });

        return response()->json($appointmentsSummary);
    }
    /**
     * İşletme anasayfa personel randevu apisi
     *
     * @return Response
     */
    public function getPersonelClock(Request $request, Personel $personel)
    {
        $clocks = [];
        $getDate = Carbon::parse($request->input('date'));
        $checkCustomWorkTime = $personel->isCustomWorkTime($request->input('date'));
        $appointmentRange = $personel->appointmentRange->time; // Assuming this is in minutes

        $startOfDay = $getDate->copy()->startOfDay(); // 2024-06-14 00:00:00
        $endOfNextDay = $getDate->copy()->addDays(1)->endOfDay(); // 2024-06-15 23:59:59
        // Get all appointments for the given date
        $appointments = $personel->appointments()
            //->whereDate('start_time', $getDate)
            ->whereBetween('start_time', [$startOfDay, $endOfNextDay])
            ->whereNotIn('status', [3])
            ->orderBy('start_time')
            ->get();

        $lastAppointment = null;
        if (isset($checkCustomWorkTime)) { // özel saat aralığı verilmişmi kontrol et

            $startTime = Carbon::parse($getDate->format('Y-m-d').' '.$checkCustomWorkTime->start_time->format("H:i:s"));
            $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$checkCustomWorkTime->end_time->format("H:i:s"));
            $i = $startTime;
            if ($endTime < $i){ // verilmişse  ve bitiş tarihi başlangıç saatinden küçükse örneğin bitiş 03:00 başlangıç 09:00
                while ($i < $endTime->endOfDay()) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
                        if (
                            ($slotStart >= $appointmentStart && $slotStart < $appointmentEnd) ||
                            ($slotEnd > $appointmentStart && $slotEnd <= $appointmentEnd) ||
                            ($slotStart <= $appointmentStart && $slotEnd >= $appointmentEnd)
                        ) {
                            $isBooked = true;
                            $appointmentDetails = $appointment;
                            break;
                        }
                    }

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = $this->generateClockEntry($slotStart, $slotEnd, $isBooked, $appointmentDetails);
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
                $i = $startTime->startOfDay();

                $endTime = Carbon::parse($getDate->addDays(1)->format('Y-m-d').' '.$checkCustomWorkTime->end_time);
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
                        if (
                            ($slotStart >= $appointmentStart && $slotStart < $appointmentEnd) ||
                            ($slotEnd > $appointmentStart && $slotEnd <= $appointmentEnd) ||
                            ($slotStart <= $appointmentStart && $slotEnd >= $appointmentEnd)
                        ) {
                            $isBooked = true;
                            $appointmentDetails = $appointment;
                            break;
                        }
                    }

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = $this->generateClockEntry($slotStart, $slotEnd, $isBooked, $appointmentDetails);

                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            } else{ // özel aralığa normal saat aralığı verilmişse
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
                        if (
                            ($slotStart >= $appointmentStart && $slotStart < $appointmentEnd) ||
                            ($slotEnd > $appointmentStart && $slotEnd <= $appointmentEnd) ||
                            ($slotStart <= $appointmentStart && $slotEnd >= $appointmentEnd)
                        ) {
                            $isBooked = true;
                            $appointmentDetails = $appointment;
                            break;
                        }
                    }

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = $this->generateClockEntry($slotStart, $slotEnd, $isBooked, $appointmentDetails);

                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            }

        } else{ // özel saat aralığı yoksa. sadece personel kendi saatleri varsa
            $startTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->start_time);
            $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->end_time);
            $i = $startTime;
            if ($endTime < $i){ // kendi saatlerine ve bitiş tarihi başlangıç saatinden küçükse örneğin bitiş 03:00 başlangıç 09:00
                while ($i < $endTime->endOfDay()) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
                        if (
                            ($slotStart >= $appointmentStart && $slotStart < $appointmentEnd) ||
                            ($slotEnd > $appointmentStart && $slotEnd <= $appointmentEnd) ||
                            ($slotStart <= $appointmentStart && $slotEnd >= $appointmentEnd)
                        ) {
                            $isBooked = true;
                            $appointmentDetails = $appointment;
                            break;
                        }
                    }

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = $this->generateClockEntry($slotStart, $slotEnd, $isBooked, $appointmentDetails);

                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
                $i = $startTime->startOfDay();

                $endTime = Carbon::parse($getDate->addDays(1)->format('Y-m-d').' '.$checkCustomWorkTime->end_time);
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
                        if (
                            ($slotStart >= $appointmentStart && $slotStart < $appointmentEnd) ||
                            ($slotEnd > $appointmentStart && $slotEnd <= $appointmentEnd) ||
                            ($slotStart <= $appointmentStart && $slotEnd >= $appointmentEnd)
                        ) {
                            $isBooked = true;
                            $appointmentDetails = $appointment;
                            break;
                        }
                    }

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = $this->generateClockEntry($slotStart, $slotEnd, $isBooked, $appointmentDetails);
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            } else{ // kendi saatine normal saat aralığı verilmişse
                while ($i < $endTime) {
                    $slotStart = $i->copy();
                    $slotEnd = $i->copy()->addMinutes($appointmentRange);

                    // Check if the current slot overlaps with any appointment
                    $isBooked = false;
                    $appointmentDetails = null;

                    foreach ($appointments as $appointment) {
                        $appointmentStart = Carbon::parse($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->end_time);

                        // SlotStart veya slotEnd'in bir randevu aralığına denk gelip gelmediğini kontrol edin
                        if (
                            ($slotStart >= $appointmentStart && $slotStart < $appointmentEnd) ||
                            ($slotEnd > $appointmentStart && $slotEnd <= $appointmentEnd) ||
                            ($slotStart <= $appointmentStart && $slotEnd >= $appointmentEnd)
                        ) {
                            $isBooked = true;
                            $appointmentDetails = $appointment;
                            break;
                        }
                    }

                    if ($isBooked && $lastAppointment && $lastAppointment->id == $appointmentDetails->id) {
                        // Eğer mevcut randevu aynı randevunun devamıysa, sadece bitiş saatini güncelle
                        $clocks[count($clocks) - 1]['clock'] = $clocks[count($clocks) - 1]['clock_start'] . "-" . $slotEnd->format('H:i');
                    } else {
                        $clocks[] = $this->generateClockEntry($slotStart, $slotEnd, $isBooked, $appointmentDetails);
                    }

                    // Eğer randevu devam ediyorsa lastAppointment'ı güncelle
                    $lastAppointment = $isBooked ? $appointmentDetails : null;

                    // Move to the next slot
                    $i->addMinutes($appointmentRange);
                }
            }
        }
        return $clocks;
    }
    private function generateClockEntry(Carbon $slotStart, Carbon $slotEnd, bool $isBooked, $appointmentDetails): array
    {
        return [
            'clock' => $slotStart->format('H:i')."-".$slotEnd->format('H:i'),
            'clock_start' => $slotStart->format('H:i'), // Save the start time
            'title' => $isBooked ? $appointmentDetails->service->subCategory->name : '',
            'appointment_id' => $isBooked ? $appointmentDetails->appointment_id : "",
            'customer' => $isBooked ? CustomerListResource::make($appointmentDetails->appointment->customer) : "",
            'routeType' => $isBooked ? 'appointmentDetail' : 'createAppointment',
            'status' => $isBooked,
            'salon' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->name : "Salon",
            'salon_color' => isset($appointmentDetails->appointment->room) ? '#3C525E' : "#3C525E",
            'color_code' => $isBooked ? '#00000019' : '#88F7C2',
        ];
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
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->input('password'));
            if ($user->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Şifreniz Güncellendi"
                ]);
            }
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Mevcut Şifrenizi Hatalı Tuşladınız"
            ], 422);
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
