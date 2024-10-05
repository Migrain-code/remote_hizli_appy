<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessService\ServiceAddRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Service\ServiceCategoryResource;
use App\Models\BusinessService;
use App\Models\BusinnessType;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;

/**
 * @group BusinessService
 *
 */
class BusinessServiceController extends Controller
{
    /**
     * GET api/business-service
     *
     * Hizmetlerin listesini döndürecek size buradaki hizmet listesinden seçilen hizmetlerden seçilen hizmet eklenecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2Get(Request $request)
    {
        $user = $request->user();
        $services = ServiceCategory::all();

        return response()->json([
            'services' => ServiceCategoryResource::collection($services),
            'typeList' => BusinnessType::all(),
            'businessServices' => BusinessServiceResource::collection($user->business->service),
        ]);
    }

    /**
     * POST api/business-service/add
     *
     * Hizmetlerin listesini döndürecek size buradaki hizmet listesinden seçilen hizmetlerden seçilen hizmet eklenecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> typeId |required | cinsiyet id si gelecek buradan  </li>
     * <li> categoryId |required | hizmetin category id si gelecek buradan  </li>
     * <li> subCategoryId |required | hizmetin sub_category id si gelecek buradan  </li>
     * <li> time |required | hizmetin süresi gelecek buradan  </li>
     * <li> price |required | hizmetin fiyatı gelecek buradan  </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2AddService(ServiceAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $newBusinessService = new BusinessService();
        $newBusinessService->business_id = $business->id;
        $newBusinessService->category = $request->input('categoryId');
        $newBusinessService->sub_category = $request->input('subCategoryId');

        $newBusinessService->type = $request->typeId; // kurulumda hizmet eklerken bu bilgilere ihtiyaç olmadığı için kapatıldı
        $newBusinessService->time = $request->input('time');
        $newBusinessService->price = $request->input('price');
        $newBusinessService->is_featured = $request->prefered;

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
            'businessServices' => BusinessServiceResource::collection($business->services),
        ]);
    }

    /**
     * Çoklu Hizmet Ekleme
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function totalAddService(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        foreach ($request->services as $serviceId) {
            $findService = ServiceSubCategory::find($serviceId);
            $newBusinessService = new BusinessService();
            $newBusinessService->business_id = $business->id;
            $newBusinessService->category = $findService->category_id;
            $newBusinessService->sub_category = $serviceId;
            $newBusinessService->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Hizmetler Kayıt Edildi.",
        ]);
    }
    /**
     * POST api/business-service/update
     *
     * id si gönderilen işletme hizmetinin bilgilerini güncelleyek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>businessServiceId | required | güncellenecek hizmetin idsi</li>
     * <li> typeId |required | cinsiyet id si gelecek buradan  </li>
     * <li> categoryId |required | hizmetin category id si gelecek buradan  </li>
     * <li> subCategoryId |required | hizmetin sub_category id si gelecek buradan  </li>
     * <li> time |required | hizmetin süresi gelecek buradan  </li>
     * <li> price |required | hizmetin fiyatı gelecek buradan  </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2UpdateService(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        $businessService = BusinessService::find($request->input('businessServiceId'));
        if ($businessService) {
            $businessService->business_id = $business->id;
            $businessService->type = $request->typeId;
            $businessService->category = $request->input('categoryId');
            $businessService->sub_category = $request->input('subCategoryId');
            $businessService->time = $request->input('time');
            $businessService->price = $request->input('price');
            $businessService->is_featured = $request->prefered;
            if ($request->input('price_type_id') == 1) {
                $businessService->price = $request->input('min_price');
                $businessService->max_price = $request->input('max_price');
            } else {
                $businessService->price = $request->input('price');
            }
            $businessService->price_type_id = $request->input('price_type_id');
            $businessService->approve_type = $request->input('approve_type');
            $businessService->save();

            return response()->json([
                'status' => "success",
                'message' => "Hizmet Bilgisi Güncellendi",
                'businessServices' => BusinessServiceResource::collection($business->services),
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hizmet Bulunamadı",
            ]);
        }

    }

    /**
     * POST api/business-service/get
     *
     * id si gönderilen işletme hizmetinin bilgilerini getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>businessServiceId | required | güncellenecek hizmetin idsi</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2GetService(Request $request)
    {
        $businessService = BusinessService::find($request->input('businessServiceId'));
        if ($businessService) {
            return response()->json([
                'status' => "success",
                'businessService' => BusinessServiceResource::make($businessService),
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hizmet Bulunamadı",
            ]);
        }
    }

    /**
     * POST api/business-service/delete
     *
     * id si gönderilen işletme hizmetinin bilgilerini getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>businessServiceId | required | güncellenecek hizmetin idsi</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step2DeleteService(Request $request)
    {
        $businessService = BusinessService::find($request->input('businessServiceId'));
        if ($businessService) {
            $businessService->delete();
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Silindi",
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hizmet Bulunamadı",
            ]);
        }
    }
}
