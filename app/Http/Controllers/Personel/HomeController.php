<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personel\PersonalAddRequest;
use App\Http\Requests\Personel\PersonalUpdateRequest;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\Personel\PersonelResource;
use App\Models\AppointmentRange;
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
 * @group Personal
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
     * Personel Anasayfası
     * @param Request $request
     * @return array
     */
    public function getClock(Request $request)
    {
        $personel = $this->personel;
        $clocks = [];
        $getDate = Carbon::parse($request->appointment_date);
        $i = Carbon::parse($getDate->format('Y-m-d').' '.$personel->start_time);
        $endTime = Carbon::parse($getDate->format('Y-m-d').' '.$personel->end_time);

        while ($i < $endTime){

            $getAppointment = $personel->appointments()->where('start_time', $i->toDateTime())->first();
            $clocks[] = [
                'clock' => $i->format('H:i'). "-". $i->addMinute($personel->appointmentRange->time)->format('H:i'),
                'title' =>isset($getAppointment) ? $getAppointment->service->subCategory->name : '',
                'customer' =>isset($getAppointment) ? CustomerDetailResource::make($getAppointment->appointment->customer) : "",
                'appointmentId' =>isset($getAppointment) ? $getAppointment->appointment_id : '',
                'status' => isset($getAppointment),
                'color_code' =>  isset($getAppointment) ? $getAppointment->status('color_code') : 'primary',
            ];
        }

        return $clocks;
    }
}
