<?php

namespace App\Http\Controllers;

use App\Http\Requests\Appointment\ServiceAddRequest;
use App\Http\Resources\BusinessServiceResource;
use App\Http\Resources\PersonelListResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\BusinessService;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Appointment
 *
 */
class AppointmentServicesController extends Controller
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
     * Randevu Hizmet Listesi
     * @param AppointmentServices $appointment
     * @return Response
     */
    public function index(Appointment $appointment)
    {
        //Randevudaki hizmetler bu listede bulunmayacaktır
        $appointmentServiceIds = $appointment->services()->pluck('service_id')->toArray();
        //Randevudaki personeller listeye eklenecek
        $appointmentPersonelIds = $appointment->services()->pluck('personel_id')->toArray();
        // aynı olan id leri ele
        $personelIds = array_unique($appointmentPersonelIds);
        // collection olarak personelleri al
        $personels = Personel::whereIn('id', $personelIds)->get();
        // collection olarak hizmetleri al
        $services = $this->business->services()->whereNotIn('id', $appointmentServiceIds)->get();
        return response()->json([
            'services' => BusinessServiceResource::collection($services),
            'personels' => PersonelListResource::collection($personels)
        ]);
    }

    /**
     * Randevuya Hizmet Ekleme
     *
     * @param Request $request
     * @return Response
     */
    public function store(ServiceAddRequest $request, Appointment $appointment)
    {
        $lastService = $appointment->services()->latest('start_time')->first();
        $endTime = $lastService->end_time;
        $findService = BusinessService::find($request->serviceId);

        $appointmentService = new AppointmentServices();
        $appointmentService->appointment_id = $appointment->id;
        $appointmentService->personel_id = $request->personelId;
        $appointmentService->service_id = $request->serviceId;
        $appointmentService->start_time = $endTime;
        $appointmentService->end_time = $endTime->addMinutes($findService->time);
        $appointmentService->save();

        return response()->json([
            'status' => "success",
            'message' => "Randevuya Hizmet Eklendi"
        ]);
    }

    /**
     * Randevudan Hizmet Silme
     *
     * Burada dikkat etmen gereken randevudaki hizmetin id sini göndermeniz olacaktır url'de
     *
     */
    public function destroy(AppointmentServices $appointmentServices)
    {
        $serviceCount = $appointmentServices->appointment->services->count();
        if($serviceCount > 1){
           $appointmentServices->delete();
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Bu Randevudan Kaldırıldı"
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Randevudaki Son Hizmet Kaldıramazsınız"
        ], 422);
    }
}
