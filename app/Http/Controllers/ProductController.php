<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAddRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Product
 *
 */
class ProductController extends Controller
{
    /**
     * Ürün listesi 
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        return response()->json(ProductResource::collection($business->products));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Ürün oluşturma 
     *
     * @param Request $request
     * @return Response
     */
    public function store(ProductAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $product = new Product();
        $product->business_id = $business->id;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->piece = $request->input('amount');
        $product->barcode = $request->input('barcode');
        if ($product->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Ürün Başarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    /**
     * Ürün bilgileri alma 
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        return response()->json(ProductResource::make($product));
    }

    /**
     * Ürün güncelleme 
     *
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->piece = $request->input('amount');
        $product->barcode = $request->input('barcode');
        if ($product->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Ürün Başarılı Bir Şekilde Güncellendi"
            ]);
        }
    }

    /**
     * Ürün silme 
     *
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        if ($product->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Ürün Başarılı Bir Şekilde Silindi"
            ]);
        }
    }
}
