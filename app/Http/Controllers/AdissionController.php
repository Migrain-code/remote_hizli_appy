<?php

namespace App\Http\Controllers;

use App\Http\Requests\Adission\AdissionSaveRequest;
use App\Http\Requests\Adission\ProductSaleAddRequest;
use App\Http\Resources\AppointmentDetailResoruce;
use App\Http\Resources\AppointmentResource;
use App\Http\Resources\PersonelListResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSaleListResource;
use App\Models\Appointment;
use App\Models\CustomerCashPoint;
use App\Models\Product;
use App\Models\ProductSales;
use Illuminate\Http\Request;

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
        //$reqDate = Carbon::parse($request->date)->format('Y-m-d');
        //$appoinments = $business->appointments()->whereDate('start_time', $reqDate)->orderBy('start_time', 'asc')->get();
        $appoinments = $business->appointments()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "open") {
                $q->where('status', 2);
            } elseif ($request->listType == "closed") {
                $q->whereIn('status', [5, 6]);
            } elseif ($request->listType == "canceled") {
                $q->whereIn('status', [3, 4]);
            } else {
                $q->where('status', 2);
            }
        })->get();
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

        return response()->json([
            'status' => "success",
            'message' => "Adission durumu güncellendi"
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
        $adission->status = 1;
        $adission->save();

        return response()->json([
            'status' => "success",
            'message' => "Ürün Satışı Yapıldı"
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
        $adission->status = 1;
        $adission->save();
        return response()->json([
            'status' => "success",
            'message' => "Ürün Satışı Yapıldı"
        ]);
    }
}
