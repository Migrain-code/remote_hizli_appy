<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

/**
 * @group Appointment
 *
 */
class AppointmentController extends Controller
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
     * Tüm Randevular
     *
     *
     * listType = thisDay
     * listType = thisWeek
     * listType = thisMonth
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        //$reqDate = Carbon::parse($request->date)->format('Y-m-d');
        //$appoinments = $business->appointments()->whereDate('start_time', $reqDate)->orderBy('start_time', 'asc')->get();
        $appoinments = $business->appointments()->when($request->filled('listType'), function ($q) use ($request) {
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
                $q->whereDate('start_time', now()->toDateString());
            }
        })->take(40)->orderBy('start_time', 'desc')->get();
        return response()->json(AppointmentResource::collection($appoinments));
    }

    /**
     * Randevu Detayı
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $appointment)
    {
        return response()->json(AppointmentDetailResoruce::make($appointment));
    }

    /**
     * Randevu Tamamla
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $appointment->status = 2;
        $appointment->save();
        foreach ($appointment->services as $service){
            $service->status = 2;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Randevuya Durumu Başarılı Bir Şekilde Güncellendi"
        ]);
    }

    /**
     * Randevu Onayla
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(Appointment $appointment)
    {
        $appointment->status = 1;
        $appointment->save();
        foreach ($appointment->services as $service){
            $service->status = 1;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Randevuya Durumu Başarılı Bir Şekilde Güncellendi"
        ]);
    }
    /**
     * Randevu Notu Kaydet
     *
     * Body içerisinde
     * note olarak göndermeniz yeterlidir.
     * @param \Illuminate\Http\Request $request
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->note = $request->note;
        $appointment->save();

        return response()->json([
            'status' => "success",
            'message' => "Randevuya Not Edildi"
        ]);
    }

    /**
     * Randevu İptal Et
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->status = 3;
        $appointment->save();
        foreach ($appointment->services as $service){
            $service->status = 3;
            $service->save();
        }
        DB::table('jobs')->where('id', $appointment->job_id)->delete();
        return response()->json([
            'status' => "success",
            'message' => "Randevu İptal Edildi"
        ]);
    }
}
