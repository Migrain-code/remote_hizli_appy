<?php

namespace App\Http\Controllers\ProductSale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductSaleAddRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\ProductSale\ProductSaleDetailResource;
use App\Http\Resources\ProductSale\ProductSaleListResource;
use App\Models\Product;
use App\Models\ProductSales;
use Illuminate\Http\Request;

/**
 * @group ProductSale
 *
 *
 */
class ProductSaleController extends Controller
{
    /**
     * Ürün Satış Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $sales = $business->sales()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('created_at', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('created_at', now()->toDateString());
            }
        })->get();

        return response()->json(ProductSaleListResource::collection($sales));
    }

    /**
     * Ürün Satış Ekleme
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $paymentTypes = ProductSales::PAYMENT_TYPES;
        $customers = $business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
                });
            })
            ->take(30)->get();
        return response()->json([
            'customers' => CustomerListResource::collection($customers),
            'products' => ProductResource::collection($business->products),
            'personels' => PersonelListResource::collection($business->personels),
            'paymentTypes' => $paymentTypes,
        ]);
    }

    /**
     * Ürün Satış Oluşturma
     *
     * note | isteğe göre gönderilebilir
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductSaleAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $productFind = Product::find($request->input('product_id'));
        $newAmount = $productFind->piece - $request->input('amount');
        if($newAmount < 0){
            return response()->json([
                'status' => "error",
                'message' => "Satışını Yapmaya Çalıştığınız Ürünün Stoğu Yetersiz. Ürüne Stok Eklemesi Yaparak Satışı Gerçekleştirebilirsiniz"
            ]);
        }

        $productSale = new ProductSales();
        $productSale->business_id = $business->id;
        $productSale->customer_id = $request->input('customer_id');
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type_id');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price')) * $request->input('amount');
        $productSale->note = $request->input('note');
        $productSale->created_at = $request->input('date');
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
     * Ürün Satış Düzenleme
     *
     * @param ProductSales $productSale
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSales $productSale)
    {
        return response()->json(ProductSaleDetailResource::make($productSale));
    }

    /**
     * Ürün Satış Güncelleme
     *
     * @param \Illuminate\Http\Request $request
     * @param ProductSales $productSale
     * @return \Illuminate\Http\Response
     */
    public function update(ProductSaleAddRequest $request, ProductSales $productSale)
    {
        $user = $request->user();
        $business = $user->business;


        $productFind = Product::find($request->input('product_id'));

        $newAmount = $productSale->piece + ($productFind->piece - $request->input('amount'));
        if($newAmount < 0){
            return response()->json([
                'status' => "error",
                'message' => "Satışını Güncellemeye Çalıştığınız Ürünün Stoğu Yetersiz. Ürüne Stok Eklemesi Yaparak Satışı Gerçekleştirebilirsiniz"
            ]);
        }

        $productSale->business_id = $business->id;
        $productSale->customer_id = $request->input('customer_id');
        $productSale->product_id = $request->input('product_id');
        $productSale->personel_id = $request->input('personel_id');
        $productSale->payment_type = $request->input('payment_type_id');
        $productSale->piece = $request->input('amount');
        $productSale->total = $this->sayiDuzenle($request->input('price')) * $request->input('amount');
        $productSale->note = $request->input('note');

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
     * Ürün Satışı Silme
     *
     * @param ProductSales $productSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSales $productSale)
    {

        $productFind = Product::find($productSale->product_id);
        if (isset($productFind)){
            $productFind->piece = $productFind->piece + $productSale->piece;
            $productFind->save();
        }

        if ($productSale->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Ürün Satışı Silindi. Satılan Ürün Adedi Ürün Stoğuna Geri Eklendi"
            ]);
        }
    }

    function sayiDuzenle($sayi){
        $sayi = str_replace('.','',$sayi);
        $sayi = str_replace(',','.',$sayi);
        $sonuc = floatval($sayi);
        return $sonuc;
    }
}
