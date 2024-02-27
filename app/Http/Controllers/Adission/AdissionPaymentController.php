<?php

namespace App\Http\Controllers\Adission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adission\PaymentAddRequest;
use App\Http\Requests\Adission\ProductSaleAddRequest;
use App\Http\Resources\Adission\AdissionDetailResoruce;
use App\Http\Resources\PersonelListResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSaleListResource;
use App\Models\Appointment;
use App\Models\AppointmentCollectionEntry;
use App\Models\Product;
use App\Models\ProductSales;
use Illuminate\Http\Request;

/**
 * @group Adisyonlar
 *
 */
class AdissionPaymentController extends Controller
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
     * Adisyon Ödeme Detayı
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Appointment $adission)
    {
        $paymentTypes = [
            0 => ["id" => 0, "name" => "Nakit"],
            1 => ["id" => 1, "name" => "Banka / Kredi Kartı"],
            2 => ["id" => 2, "name" => "EFT / Havale"],
            3 => ["id" => 3, "name" => "Diğer"],
        ];

        return response()->json([
            'payment_info' => AdissionDetailResoruce::make($adission),
            'payment_types' => $paymentTypes,
        ]);
    }

    /**
     * Adisyon Ödeme Oluşturma
     *
     * Ödeme Tipleri bu apiden dönecek
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Appointment $adission)
    {
        $paymentTypes = [
            0 => ["id" => 0, "name" => "Nakit"],
            1 => ["id" => 1, "name" => "Banka / Kredi Kartı"],
            2 => ["id" => 2, "name" => "EFT / Havale"],
            3 => ["id" => 3, "name" => "Diğer"],
        ];

        return response()->json([
            'payment_types' => $paymentTypes,
        ]);
    }

    /**
     * Adisyon Ödeme Ekleme
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaymentAddRequest $request, Appointment $adission)
    {
        if ($this->remainingTotal($adission) == 0){
            return response()->json([
                'status' => "error",
                'message' => "Bu Adisyonda tüm ücretler tahsil edildi. Başka Tahsilat Ekleyemezsiniz."
            ], 422);
        }
        if($request->price > $this->remainingTotal($adission)){
            return response()->json([
               'status' => "error",
               'message' => "Adisyonda tahsil edilecek tutar ". $this->remainingTotal($adission). " TL'dir. Bu ücretten daha yüksek bir ücret giremezsiniz",
               'price' => $this->remainingTotal($adission)
            ], 422);
        }
        $appointmentCollection = new AppointmentCollectionEntry();
        $appointmentCollection->appointment_id = $adission->id;
        $appointmentCollection->payment_type_id = $request->payment_type_id;
        $appointmentCollection->price = $request->price;
        $appointmentCollection->save();

        return response()->json([
            'status' => "success",
            'message' => "Tahsilat Başarılı Bir Şekilde Eklendi"
        ], 200);
    }

    public function addCashPoint(Appointment $adission)
    {
        if(isset($adission->cashPoint)){

        }
    }
    public function calculateCampaignDiscount($adission){ //indirim tl dönüşümü
        $total = number_format(($adission->total * $adission->discount) / 100, 2);
        return $total;
    }
    public function calculateCollectedTotal($adission) //tahsil edilecek tutar
    {
        $total = ceil($adission->total - ((($adission->total * $adission->discount) / 100) + $adission->point));
        return $total;
    }

    public function remainingTotal($adission) //tahsil edilecek tutar
    {
        return $this->calculateCollectedTotal($adission) - $adission->payments->sum("price");
    }
}
