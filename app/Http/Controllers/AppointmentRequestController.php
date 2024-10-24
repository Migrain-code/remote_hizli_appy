<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentRequest\AppointmentRequestDetailResoruce;
use App\Http\Resources\AppointmentRequest\AppointmentRequestListResoruce;
use App\Models\BusinessAppointmentRequest;
use App\Services\Sms;
use Illuminate\Http\Request;

class AppointmentRequestController extends Controller
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

    public function index()
    {
        $requests = $this->business->requests;
        $statusList = BusinessAppointmentRequest::STATUS_LIST;
        return response()->json([
            'statusList' => $statusList,
            'appointmentRequestList' => AppointmentRequestListResoruce::collection($requests)
        ]);
    }

    public function show(BusinessAppointmentRequest $appointmentRequest)
    {
        return response()->json(AppointmentRequestDetailResoruce::make($appointmentRequest));
    }

    public function edit(BusinessAppointmentRequest $appointmentRequest)
    {
        $statusList = BusinessAppointmentRequest::STATUS_LIST;
        return response()->json([
            'statusList' => $statusList,
            'appointmentRequest' => AppointmentRequestListResoruce::make($appointmentRequest),
        ]);
    }

    public function update(Request $request,BusinessAppointmentRequest $appointmentRequest)
    {
        $appointmentRequest->user_name = $request->input('name');
        $appointmentRequest->call_date = $request->call_date;
        $appointmentRequest->status = $request->input('status');
        $appointmentRequest->answer = $request->input('answer');

        if ($appointmentRequest->save()) {
            if ($appointmentRequest->contact_type == 2 && $appointmentRequest->status != 4) {
                $message = $appointmentRequest->business->name . " İşletmesi Talebinizi Yanıtladı: " . $request->input('answer');
                Sms::send(clearPhone($appointmentRequest->phone), $message);
                $appointmentRequest->status = 4; // sms ile cevaplandı
                $appointmentRequest->sms_content = $request->input('answer'); // cevap
               /* if (!isset($appointmentRequest->sms_content)){

                }*/
            } else {
                if ($appointmentRequest->status == 4) {
                    return response()->json([
                        'status' => "warning",
                        'message' => "Form Bilgileri Güncellendi, Fakat Cevabınızı daha önce ilettiğiniz için sms gönderilmedi"
                    ]);
                }
                //$appointmentRequest->status = $request->input('status');
            }
            return response()->json([
                'status' => "success",
                'message' => "Talep Bilgileri Güncellendi"
            ]);
        }
    }

    public function destroy(BusinessAppointmentRequest $appointmentRequest)
    {
        $appointmentRequest->delete();
        return response()->json([
            'status' => "success",
            'message' => "Talep Silindi"
        ]);
    }
}
