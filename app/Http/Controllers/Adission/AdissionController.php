<?php

namespace App\Http\Controllers\Adission;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Adisyonlar
 *
 */
class AdissionController extends Controller
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
     * Adisyonlar Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        if (!isset($request->date_range)){
            if (!$request->filled('start_date') && !$request->filled('end_date')) {
                $request->merge(['date_range' => now()->format('d.m.Y') . ' - ' . now()->format('d.m.Y')]);
            } else{
                $request->merge(["date_range" => Carbon::parse($request->start_date)->format('d.m.Y'). ' - ' .Carbon::parse($request->end_date)->format('d.m.Y')]);
            }
        }
       $appoinments = $business->appointments()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "open") {
                $q->whereIn('status', [2]);//or add 1
            } elseif ($request->listType == "closed") {
                $q->whereIn('status', [5, 6]);
            } elseif ($request->listType == "canceled") {
                $q->whereIn('status', [3, 4]);
            } else {
                $q->whereNotIn('status', [0])->whereIn('status', [2]);//or add 1
            }
        })->when($request->filled('date_range'), function ($q) use ($request) {
            $startTime = now();
            $endTime = now();
            if ($request->filled('date_range')) {
                $timePartition = explode('-', $request->date_range);
                $startTime = Carbon::parse(clearPhone($timePartition[0]))->toDateString();
                $endTime = Carbon::parse(clearPhone($timePartition[1]))->toDateString();
            }
            $q->whereBetween('start_time', [$startTime, $endTime]);
        })->latest()->take(30)->get();

        return response()->json(AppointmentResource::collection($appoinments));
    }

    /**
     * Adisyon Detayı
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $adission)
    {
        return response()->json(AppointmentDetailResoruce::make($adission));
    }

    /**
     * Adisyon gelmedi
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $adission)
    {
        $adission->status = 4;
        $adission->save();
        foreach ($adission->services as $service){
            $service->status = 4;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Adisyon durumu güncellendi"
        ]);
    }

    /**
     * Adisyon Geldi
     *
     * @param \Illuminate\Http\Request $request
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $adission)
    {
        $adission->status = 5;
        $adission->save();
        foreach ($adission->services as $service){
            $service->status = 5;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Adisyon durumu güncellendi"
        ]);
    }

    /**
     * Adisyon İptal Et
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $adission)
    {
        $adission->status = 3;
        $adission->save();
        foreach ($adission->services as $service){
            $service->status = 3;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Adisyon iptal edildi"
        ]);
    }
}
