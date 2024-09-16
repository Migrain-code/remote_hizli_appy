<?php

namespace App\Http\Controllers\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Receivable\ReceivableListAddRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Receivable\ReceivableDetailResource;
use App\Http\Resources\Receivable\ReceivableListResource;
use App\Models\AppointmentReceivable;
use Illuminate\Http\Request;

/**
 * @group Alacaklar
 *
 */
class AppointmentReceivableController extends Controller
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
     * Alacaklar Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ReceivableListResource::collection($this->business->receivables));
    }

    /**
     * Alacak Oluştur
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customers = $this->business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
                });
            })->take(30)->get();
        return response()->json(CustomerListResource::collection($customers));
    }

    /**
     * Alacak Ekle
     *
     * @param  ReceivableListAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ReceivableListAddRequest $request)
    {
        $appointmentReceivable = new AppointmentReceivable();
        $this->extracted($appointmentReceivable, $request);
        return response()->json([
            'status' => "success",
            'message' => "Alacak Başarılı Bir Şekilde Eklendi"
        ]);
    }

    /**
     * Alacak Detayı
     *
     * @param  \App\Models\AppointmentReceivable  $receivable
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AppointmentReceivable $receivable)
    {
        return response()->json(ReceivableDetailResource::make($receivable));
    }

    /**
     * Alacak Düzenleme
     *
     * @param  \App\Models\AppointmentReceivable  $receivable
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(AppointmentReceivable $receivable)
    {
        return response()->json(ReceivableDetailResource::make($receivable));
    }

    /**
     * Alacak Güncelleme
     *
     * @param  ReceivableListAddRequest $request
     * @param  \App\Models\AppointmentReceivable  $receivable
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, AppointmentReceivable $receivable)
    {
        $this->extracted($receivable, $request);
        return response()->json([
            'status' => "success",
            'message' => "Alacak Başarılı Bir Şekilde Güncellendi"
        ]);
    }

    /**
     *  Alacak Silme
     *
     * @param  \App\Models\AppointmentReceivable  $receivable
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AppointmentReceivable $receivable)
    {
        if ($receivable->delete()) return response()->json([
            'status' => "success",
            'message' => "Alacak Başarılı Bir Şekilde Silindi"
        ]);
    }

    public function extracted($appointmentReceivable, $request):void
    {
        $appointmentReceivable->business_id = $this->business->id;
        $appointmentReceivable->customer_id = $request->customerId;
        $appointmentReceivable->payment_date = $request->paymentDate;
        $appointmentReceivable->price = $request->price;
        $appointmentReceivable->note = $request->note;
        $appointmentReceivable->save();
    }
}
