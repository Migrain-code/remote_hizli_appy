<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\GalleryAddRequest;
use App\Http\Resources\Gallery\GalleryListResource;
use App\Models\BusinessGallery;
use App\Services\UploadFile;
use Illuminate\Http\Request;

/**
 * @group BusinessGallery
 *
 */
class GalleryController extends Controller
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
     * İşletme Galerisi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(GalleryListResource::collection($this->business->gallery));
    }

    /**
     * Görsel Ekle
     *
     * @param  GalleryAddRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GalleryAddRequest $request)
    {
        if ($request->hasFile('image')){
            $response = UploadFile::uploadFile($request->file('image'), 'business_galleries');
            $businessGallery = new BusinessGallery();
            $businessGallery->business_id = $this->business->id;
            $businessGallery->way = $response["image"]["way"];
            $businessGallery->byte = 4564;
            $businessGallery->name = $this->business->name."_".$this->business->gallery->count();
            $businessGallery->save();
            return response()->json([
                'status' => "success",
                'message' => "Görsel Yüklendi"
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Lütfen Bir Dosya Seçiniz",
            ]);
        }
    }

    /**
     * Görsel Silme
     *
     * @param  BusinessGallery $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BusinessGallery $gallery)
    {
        if ($gallery->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Görsel Silindi"
            ]);
        }
    }
}
