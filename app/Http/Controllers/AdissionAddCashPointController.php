<?php

namespace App\Http\Controllers;

use App\Http\Resources\Customer\CashPointListResoruce;
use App\Models\Appointment;
use App\Models\CustomerCashPoint;
use Illuminate\Http\Request;

/**
 * @group Adisyonlar
 *
 */
class AdissionAddCashPointController extends Controller
{
    /**
     * Adisyon Parapuan Listesi
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index(Appointment $adission)
    {
        $customer = $adission->customer;
        return response()->json(CashPointListResoruce::collection($customer->cashPoints));
    }

    /**
     * Adisyon Parapuan Kullan
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function store(Appointment $adission, CustomerCashPoint $cashPoint)
    {
        if ($this->remainingTotal($adission) == 0){
            return response()->json([
                'status' => "error",
                'message' => "Bu Adisyonda tüm ücretler tahsil edildi. Parapuan Kullanımı Yapılamaz."
            ], 422);
        }

        if ($cashPoint->price > $this->remainingTotal($adission)){
            $collectionTotal = $cashPoint->price - $this->remainingTotal($adission);
            $adission->point = $this->remainingTotal($adission);
            $adission->save();

            $cashPoint->price = $collectionTotal;
            $cashPoint->save();
            return response()->json([
                'status' => "error",
                'message' => "Parapuan Ödemeye Uygulandı. Parapuan tutarı ödeme tutarından fazla oluduğu için parapuandan ".$adission->point." TL tahsil edildi."
            ]);
        }
        $adission->point = $cashPoint->price;
        $adission->save();

        $cashPoint->price = 0;
        $cashPoint->save();

        return response()->json([
            'status' => "success",
            'message' => "Parapuan Başarılı Bir Şekilde Kullanıldı"
        ]);
    }

    public function calculateCollectedTotal($adission) //tahsil edilecek tutar
    {
        $total = ceil($adission->total - ((($adission->total * $adission->discount) / 100) + $adission->point));
        return $total;
    }

    public function remainingTotal($adission) //kalan  tutar
    {
        return $this->calculateCollectedTotal($adission) - $adission->payments->sum("price");
    }
}
