<?php

namespace App\Http\Controllers\Promossion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promossion\PromosionUpdateRequest;
use App\Http\Resources\Promosion\PromossionListResource;
use App\Models\BusinessPromossion;

/**
 * @group Promosyonlar
 *
 */
class BusinessPromossionController extends Controller
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
     * Promosyon Listesi
     *
     * Burada işletmenin promosyon listesi dönecek. 1-100 arasında seçim alanlarında mobilde
     * değer üretilip apiden gelen rate verisine göre selected attribute aktif edilecek
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promossions = $this->business->promossions;
        if (!isset($promossions)){
            $promossion = new BusinessPromossion();
            $promossion->business_id = $this->business->id;
            $promossion->save();
        }
        return response()->json(PromossionListResource::make($promossions));
    }

    /**
     * Promosyon Kayıt Etme
     *
     * Burada işletmenin promosyon listesi dönecek. 1-100 arasında seçim alanlarında mobilde
     * değer üretilip apiden gelen rate verisine göre selected attribute aktif edilecek
     * @return \Illuminate\Http\Response
     */
    public function store(PromosionUpdateRequest $request)
    {
        $promossions = $this->business->promossions;

        $promossions->cash = $request->cash;
        $promossions->credit_cart = $request->creditCard;
        $promossions->eft = $request->eft;
        $promossions->use_limit = $request->limit;
        $promossions->birthday_discount = $request->birthday;
        if($promossions->save()){
            return response()->json([
                'status' => "success",
                'message' => "Promosyon Ayarlarınız Güncellendi"
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Sistemsel Bir Hata Oluştur Lütfen Daha Sonra Tekrar Deneyiniz"
        ], 422);
    }
}
