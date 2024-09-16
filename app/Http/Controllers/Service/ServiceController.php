<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessService\ServiceAddRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Service\PersonelListResource;
use App\Http\Resources\Service\ServiceCategoryResource;
use App\Models\BusinessService;
use App\Models\BusinnessType;
use App\Models\Personel;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

/**
 * @group Services
 *
 */
class ServiceController extends Controller
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
     * Hizmet Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $business = $this->business;
        $services = $business->services;
        return response()->json(BusinessServiceResource::collection($services));
    }

    /**
     * Hizmet Oluştur
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $services = ServiceCategory::all();

        return response()->json([
            'services' => ServiceCategoryResource::collection($services),
            'typeList' => BusinnessType::all(),
        ]);
    }

    /**
     * Hizmet Ekle
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ServiceAddRequest $request)
    {
        $newBusinessService = new BusinessService();
        $newBusinessService->business_id = $this->business->id;
        $newBusinessService->type = $request->typeId;
        $newBusinessService->category = $request->input('categoryId');
        $newBusinessService->sub_category = $request->input('subCategoryId');
        $newBusinessService->time = $request->input('time');
        $newBusinessService->is_featured = $request->prefered;
        $newBusinessService->approve_type = $request->input('approve_type');
        if ($request->input('price_type_id') == 1) {
            $newBusinessService->price = $request->input('min_price');
            $newBusinessService->max_price = $request->input('max_price');
        } else {
            $newBusinessService->price = $request->input('price');
        }
        $newBusinessService->price_type_id = $request->input('price_type_id');

        $newBusinessService->save();

        return response()->json([
            'status' => "success",
            'message' => "Yeni Hizmet Eklendi",
        ]);
    }

    /**
     * Hizmet Detayı
     *
     *  Bu apide ilgili hizmeti hangi personeller veriyor bunun listesi görüntülenecek
     * @param  BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BusinessService $service)
    {
        $personlIds = $service->personels()->pluck('personel_id')->toArray();
        $personels = Personel::whereIn('id', $personlIds)->get();
        return response()->json(PersonelListResource::collection($personels));
    }

    /**
     * Hizmet Düzenle
     *
     * @param  BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(BusinessService $service)
    {
        return response()->json(BusinessServiceResource::make($service));
    }

    /**
     * Hizmet Güncelle
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BusinessService $service)
    {
        if ($service) {
            $service->business_id = $this->business->id;
            $service->type = $request->typeId;
            $service->category = $request->input('categoryId');
            $service->sub_category = $request->input('subCategoryId');
            $service->time = $request->input('time');
            $service->price = $request->input('price');
            $service->is_featured = $request->prefered;
            if ($request->input('price_type_id') == 1) {
                $service->price = $request->input('min_price');
                $service->max_price = $request->input('max_price');
            } else {
                $service->price = $request->input('price');
            }
            $service->price_type_id = $request->input('price_type_id');
            $service->approve_type = $request->input('approve_type');
            $service->save();

            return response()->json([
                'status' => "success",
                'message' => "Hizmet Bilgisi Güncellendi",
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hizmet Bulunamadı",
            ]);
        }
    }

    /**
     * Hizmet Sil
     *
     * @param  BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BusinessService $service)
    {
        if ($service->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Silindi",
            ]);
        }
    }

    function transformServices($womanServiceCategories){
        $transformedDataWoman = [];
        foreach ($womanServiceCategories as $category => $services) {

            $transformedServices = [];
            foreach ($services as $service) {
                if ($service->personels->count() > 0){
                    $transformedServices[] = [
                        'id' => $service->id,
                        'name' => $service->subCategory->getName(),
                        'price' => $service->price,
                    ];
                }
            }
            $transformedDataWoman[] = [
                'id' => $services->first()->category,
                'name' => $category,
                'services' => $transformedServices,
            ];
        }
        return $transformedDataWoman;
    }
}
