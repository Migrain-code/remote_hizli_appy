<?php

namespace App\Http\Controllers;

use App\Http\Requests\Personel\PersonalCustomPriceAddRequest;
use App\Models\Personel;
use App\Models\PersonelCustomerPriceList;
use Illuminate\Http\Request;

class PersonelCustomerPriceListController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }

    /**
     * Hizmet Listesi
     * @param Personel $personel
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Personel $personel)
    {
        $services = $this->business->services;
        $serviceList = [];
        foreach ($services as $service){
            if (in_array($service->id, $personel->services()->pluck('service_id')->toArray())){
                $serviceList[] = [
                    "id"=> $service->id,
                    "sub_category"=> $service->subCategory->getName(),
                    'price_type_id' =>  $service->price_type_id,
                    "price"=> $personel->existCustomPrice($service->id)->price ?? $service->price,
                    'min_price' => $personel->existCustomPrice($service->id)->price ?? $service->price,
                    'max_price' => $service->max_price,
                    'is_personel_service' => in_array($service->id, $personel->services()->pluck('service_id')->toArray()),
                ];
            }
        }
        return response()->json($serviceList);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonalCustomPriceAddRequest $request, Personel $personel)
    {
        $existPersonelPrice = $personel->priceList()
            ->where('business_service_id', $request->service_id)
            ->first();
        if ($existPersonelPrice){
            if ($existPersonelPrice->price == $request->price){
                return response()->json([
                    'status' => "warning",
                    'message' => "Bu hizmette hiçbir fiyat değişikliği yapmadınız."
                ], 422);
            } else{
                $existPersonelPrice->price = $request->price;
                $existPersonelPrice->save();

                return response()->json([
                    'status' => "success",
                    'message' => "Bu hizmetin fiyatı güncellendi."
                ]);
            }

        }
        $personelCustomerPriceList = new PersonelCustomerPriceList();
        $personelCustomerPriceList->personel_id = $personel->id;
        $personelCustomerPriceList->business_service_id = $request->service_id;
        $personelCustomerPriceList->price = $request->price;
        if ($personelCustomerPriceList->save()){
            return response()->json([
               'status' => "success",
               'message' => "Bu personele yazığınız yeni hizmet fiyatı kaydedildi."
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Personel $personel)
    {
        $existPersonelPrice = $personel->priceList()
            ->where('business_service_id', $request->service_id)
            ->first();
        if ($existPersonelPrice){
            $existPersonelPrice->delete();
            $findPrice = $this->business->services()->find($request->service_id);
            $resPrice = 0;
            if ($findPrice->price_type_id == 1){
                $resPrice = $findPrice->price. " - ".$findPrice->max_price;
            } else{
                $resPrice = $findPrice->price;
            }
            return response()->json([
                'status' => "success",
                'message' => "Bu personelde yazığınız yeni hizmet fiyatı kaldırıldı.",
                'price' => $resPrice
            ]);
        }
        else{
            return response()->json([
                'status' => "error",
                'message' => "Bu hizmet personelin özel fiyat listesine eklenmemiş."
            ], 422);
        }
    }
}
