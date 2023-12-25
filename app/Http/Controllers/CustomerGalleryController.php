<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerGalleryAddRequest;
use App\Http\Resources\CustomerGalleryResource;
use App\Models\CustomerGallery;
use App\Services\UploadFile;
use Illuminate\Http\Request;

/**
 * @group CustomerGallery
 *
 */
class CustomerGalleryController extends Controller
{
    /**
     * Müşteri Galerisi
     *
     * customer_id gönderilmesi yeterli
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        $images = CustomerGallery::where('customer_id', $request->customer_id)
            ->where('business_id', $business->id)
            ->get();

        return response()->json(CustomerGalleryResource::collection($images));
    }

    /**
     * Galeriye Görsel Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerGalleryAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $customerGallery = new CustomerGallery();
        $customerGallery->customer_id = $request->customer_id;
        $customerGallery->business_id = $business->id;
        if ($request->hasFile('image')){
            $response = UploadFile::uploadFile($request->file('image'), 'customer_gallery');
            $customerGallery->image = $response["image"]["way"];
        }
        else{
            return response()->json([
                'status' => "error",
                'message' => "Görsel Seçilmesi Zorunludur."
            ]);
        }
        if ($customerGallery->save()){
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Görseli Eklendi."
            ]);
        }
    }


    /**
     * Galeriden Görsel Silme
     *
     * @param  \App\Models\CustomerGallery  $customerGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerGallery $customerGallery)
    {
        if ($customerGallery->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Görseli Silindi."
            ]);
        }
    }
}
