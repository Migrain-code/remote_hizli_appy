<?php

namespace App\Http\Controllers\Adission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adission\ProductSaleAddRequest;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ProductSale\ProductSaleDetailResource;
use App\Http\Resources\ProductSale\ProductSaleListResource;
use App\Models\Appointment;
use App\Models\Product;
use App\Models\ProductSales;

/**
 * @group Adisyonlar
 *
 */
class AdissionProductSaleController extends Controller
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
     * Adisyon Ürün Satışı Listesi
     *
     * @param  Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Appointment $adission)
    {
        return response()->json(ProductSaleListResource::collection($adission->sales));
    }

    /**
     * Adisyon Ürün Satışı Oluşturma
     *
     * Adisyonda ürün satışı yapılabilmesi için gerekli bilgileri döndürür
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $paymentTypes = ProductSales::PAYMENT_TYPES;

        return response()->json([
            'products' => ProductResource::collection($this->business->products),
            'personels' => PersonelListResource::collection($this->business->personels),
            'paymentTypes' => $paymentTypes,
        ]);
    }

    /**
     * Adisyona Ürün Satışı Ekleme
     *
     * @requires product_id
     * @requires personel_id
     * @requires payment_type_id
     * @requires amount
     * @requires price
     * @param  \Illuminate\Http\Request  $request
     * @param  Appointment $adission
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(ProductSaleAddRequest $request, Appointment $adission)
    {
        $productFind = Product::find($request->input('product_id'));
        $newAmount = $productFind->piece - $request->input('amount');
        if($newAmount < 0){
            return response()->json([
                'status' => "error",
                'message' => "Satışını Yapmaya Çalıştığınız Ürünün Stoğu Yetersiz. Ürüne Stok Eklemesi Yaparak Satışı Gerçekleştirebilirsiniz"
            ],422);
        }

        $productSale = new ProductSales();
        $productSale->appointment_id = $adission->id;
        $productSale->business_id = $this->business->id;
        $productSale->customer_id = $adission->customer_id;
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type_id');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price')) * $request->input('amount');
        $productSale->note = $request->input('note');
        $productSale->created_at = $adission->start_time;
        if ($productSale->save()) {
            $productFind->piece = $productFind->piece - $productSale->piece;
            $productFind->save();
            return response()->json([
                'status' => "success",
                'message' => "Ürün Satışı Yapıldı"
            ]);
        }
    }
    /**
     * Adisyon Ürün Satışı Düzenleme
     *
     * Adisyonda ürün satışı düzenlemesi için gerekli bilgileri döndürür
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(ProductSales $productSale)
    {
        $paymentTypes = ProductSales::PAYMENT_TYPES;

        return response()->json([
            'sale_detail' =>ProductSaleDetailResource::make($productSale)
        ]);
    }

    /**
     * Adisyona Ürün Satışı Güncelleme
     *
     * @requires product_id
     * @requires personel_id
     * @requires payment_type_id
     * @requires amount
     * @requires price
     * @param  \Illuminate\Http\Request  $request
     * @param  Appointment $adission
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function update(ProductSaleAddRequest $request, Appointment $adission, ProductSales $productSale)
    {
        $saleProduct = $productSale->product; //satışı yapılan ürünü bul
        $saleProduct->piece += $productSale->piece; //satışı yapılan ürünü güncellemeden önce eski stok adedine çevir
        $saleProduct->save();

        $productFind = Product::find($request->input('product_id'));
        $newAmount = $productFind->piece - $request->input('amount');
        if($newAmount < 0){
            return response()->json([
                'status' => "error",
                'message' => "Satışını Yapmaya Çalıştığınız Ürünün Stoğu Yetersiz. Ürüne Stok Eklemesi Yaparak Satışı Gerçekleştirebilirsiniz"
            ]);
        }

        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type_id');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price')) * $request->input('amount');
        $productSale->note = $request->input('note');
        $productSale->created_at = $adission->start_time;
        if ($productSale->save()) {
            $productFind->piece = $productFind->piece - $productSale->piece;
            $productFind->save();
            return response()->json([
                'status' => "success",
                'message' => "Ürün Satışı Güncellendi"
            ]);
        }
    }

    /**
     * Adisyon Ürün Satışı Silme
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Appointment $adission
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(ProductSales $productSale)
    {
        $saleProduct = $productSale->product; //satışı yapılan ürünü bul
        $saleProduct->piece += $productSale->piece; //satışı yapılan ürünü silmeden önce eski stok adedine çevir
        $saleProduct->save();

        $productSale->delete();
        return response()->json([
            'status' => "success",
            'message' => "Ürün Satışı Silindi"
        ]);
    }
    function sayiDuzenle($sayi){
        $sayi = str_replace('.','',$sayi);
        $sayi = str_replace(',','.',$sayi);
        $sonuc = floatval($sayi);
        return $sonuc;
    }
}
