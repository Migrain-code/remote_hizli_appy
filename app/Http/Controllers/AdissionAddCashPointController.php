<?php

namespace App\Http\Controllers;

use App\Http\Resources\Customer\CashPointListResoruce;
use App\Http\Resources\Receivable\ReceivableListResource;
use App\Models\Appointment;
use App\Models\AppointmentReceivable;
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
        if ($this->remainingTotal($adission) == 0) {
            return response()->json([
                'status' => "error",
                'message' => "Bu Adisyonda tüm ücretler tahsil edildi. Parapuan Kullanımı Yapılamaz."
            ], 422);
        }

        if ($cashPoint->price > $this->remainingTotal($adission)) {
            $collectionTotal = $cashPoint->price - $this->remainingTotal($adission);
            $adission->point = $this->remainingTotal($adission);
            $adission->save();

            $cashPoint->price = $collectionTotal;
            $cashPoint->save();
            return response()->json([
                'status' => "error",
                'message' => "Parapuan Ödemeye Uygulandı. Parapuan tutarı ödeme tutarından fazla oluduğu için parapuandan " . $adission->point . " TL tahsil edildi."
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
    /**
     * Adisyon Alacak Listesi
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableList(Appointment $adission)
    {
        return response()->json(ReceivableListResource::collection($adission->receivables
            //->whereStatus(0)->get()
        ));
    }
    /**
     * Adisyon Alacak Oluştur
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableAdd(Request $request,Appointment $adission)
    {
        if ($this->remainingTotal($adission) == 0){
            return response()->json([
                'status' => "error",
                'message' => "Bu adisyonun tüm ücreti tahsil edildi.Yeni Alacak ekleyemezsiniz."
            ], 422);
        }
        $totalReceivable = $adission->receivables->sum('price');

        if ($totalReceivable + $request->price > $this->remainingTotal($adission)){
            $sum = $this->remainingTotal($adission) - $totalReceivable;
            if ($sum == 0){
                return response()->json([
                    'status' => "error",
                    'message' => "Bu adisyonun tutarına denk gelecek kadar alacak eklediniz. Daha Fazla Alacak Ekleyemezsiniz."
                ], 422);
            }

            return response()->json([
                'status' => "error",
                'message' => "Adisyona Eklediğiniz Alacakların Toplamı ve Gönderdiğini Tutar Adisyonun Kalan Ücretini Geçemez. ". $sum . " TL'den fazla fiyat giremezsiniz."
            ], 422);
        }
        if ($request->price  > $this->remainingTotal($adission)){
            return response()->json([
                'status' => "error",
                'message' => "Gönderdiğiniz Tutar. Adisyonun Kalan Ücretini Geçemez. ". $this->remainingTotal($adission). " TL'den fazla fiyat giremezsiniz."
            ], 422);
        }
        $receivable = new AppointmentReceivable();
        $receivable->appointment_id = $adission->id;
        $receivable->business_id = $adission->business_id;
        $receivable->customer_id = $adission->customer_id;
        $receivable->payment_date = $request->paymentDate;
        $receivable->price = $request->price;
        $receivable->note = $request->note;
        if ($receivable->save()){
            return response()->json([
                'status' => "success",
                'message' => "Alacak Başarılı Bir Şekilde Oluşturuldu"
            ]);
        }
    }
    /**
     * Adisyon Alacak Sil
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableDelete(Appointment $adission, AppointmentReceivable $receivable)
    {
        if ($receivable->status == 1){
            return response()->json([
                'status' => "success",
                'message' => "Ödemesi Onaylanmış Bir Alacağı Silemezsiniz"
            ], 422);
        }
        if ($receivable->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Alacak Başarılı Bir Şekilde Silindi"
            ]);
        }
    }

    /**
     * Adisyon Alacak Ödendi Güncelle
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableUpdate(Appointment $adission, AppointmentReceivable $receivable)
    {
        if ($receivable->status == 1){
            return response()->json([
                'status' => "error",
                'message' => "Ödemeyi Daha Önce Onayladınız"
            ], 422);
        }
        $receivable->status = 1;
        if ($receivable->save()){

            return response()->json([
                'status' => "success",
                'message' => "Alacak Ödemesi Başarılı Bir Şekilde Onaylandı"
            ]);
        }
    }
    public function calculateCollectedTotal($adission) //tahsil edilecek tutar
    {
        $total = ceil($adission->total - ((($adission->total * $adission->discount) / 100) + $adission->point));
        return $total;
    }

    public function remainingTotal($adission) //kalan  tutar
    {
        return ($this->calculateCollectedTotal($adission) - $adission->payments->sum("price")) - $adission->receivables()->whereStatus(1)->sum('price');
    }
}
