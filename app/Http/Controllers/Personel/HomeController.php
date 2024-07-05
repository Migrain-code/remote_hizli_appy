<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personel\PersonalAddRequest;
use App\Http\Requests\Personel\PersonalUpdateRequest;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Personel\PersonelResource;
use App\Http\Resources\PersonelAccount\Home\CustomerListResource;
use App\Models\Appointment;
use App\Models\AppointmentRange;
use App\Models\AppointmentServices;
use App\Models\Business;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelRestDay;
use App\Models\PersonelService;
use App\Models\ServiceCut;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * @group Personal Anasayfa
 *
 */
class HomeController extends Controller
{
    private $personel;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->personel = auth('personel')->user();
            return $next($request);
        });
    }

    /**
     * Tarih Listesi
     * @return \Illuminate\Http\JsonResponse
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
     * Personel Anasayfa Randevu
     *
     * @urlParam appointment_date | date
     *
     * appointment_date gönderilecek
     * @param Request $request
     * @return array
     */
    public function getClock(Request $request)
    {
        $personel = $this->personel;
        $clocks = [];
        $getDate = Carbon::parse($request->appointment_date);
        $checkCustomWorkTime = $personel->isCustomWorkTime($request->appointment_date);
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

            $startTime = Carbon::parse($getDate->format('Y-m-d').' '.$checkCustomWorkTime->start_time);
            $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$checkCustomWorkTime->end_time);
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
            'salon_color' => isset($appointmentDetails->appointment->room) ? $appointmentDetails->appointment->room->color : "#009ef7",
            'color_code' => $isBooked ? '#00000019' : '#88F7C2',
        ];
    }
}
