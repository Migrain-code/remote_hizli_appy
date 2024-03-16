<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personel\PersonalAddRequest;
use App\Http\Requests\Personel\PersonalUpdateRequest;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Personel\PersonelResource;
use App\Models\AppointmentRange;
use App\Models\Business;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelRestDay;
use App\Models\PersonelService;
use App\Models\ServiceCut;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Personal
 *
 */
class PersonalController extends Controller
{
    /**
     * GET api/personal
     *
     * Personel listesini döndürecek size
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3Get(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        return response()->json([
            'personals' => PersonelResource::collection($business->personels),
        ]);
    }

    /**
     * POST api/personal/add
     *
     * Personel Ekleme pointi
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> name |required | string | </li>
     * <li> image |required | string | </li>
     * <li> email |required | string | </li>
     * <li> phone |required | string | </li>
     * <li> password |required | string | </li>
     * <li> approveType |required | numeric | örneğin 1 veya 0</li>
     * <li> restDay |required | numeric | haftanın günlerinden herhangi bir günün id si</li>
     * <li> startTime |required | string | örneğin 10:43 </li>
     * <li> endTime |required | string | örneğin 10:43</li>
     * <li> foodStart |required | string | örneğin 10:43</li>
     * <li> foodEnd |required | string | örneğin 10:43</li>
     * <li> gender |required | numeric | 1 => kadın,2 => erkek,3 => Unisex herhangi biri</li>
     * <li> rate |required | numeric | 10 personel yüzdesi 10 = %10</li>
     * <li> appointmentRange |required | numeric | randevu aralığı örneğin "15" dk bazında</li>
     * <li> description |required | string</li>
     * <li> services | required | array | eğer tümü seçeneği seçilirse "all" olarak gönderebilirsiniz dizi içerisinde</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3AddPersonal(PersonalAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $personel = new Personel();
        $personel->business_id = $business->id;
        $personel->name = $request->input('name');
        $personel->image = "business/team.png";
        $personel->email = $request->email;
        $personel->password = Hash::make($request->password);
        $personel->phone = $request->phone;
        $personel->accepted_type = $request->approveType;
        $personel->accept = $request->accept;
        $personel->start_time = $request->startTime;
        $personel->end_time = $request->endTime;
        $personel->food_start = $request->foodStart;
        $personel->food_end = $request->foodEnd;
        $personel->gender = $request->gender;
        $personel->rate = $request->rate;
        $personel->range = $request->appointmentRange;
        $personel->description = $request->description;

        $dayList = DayList::all();

        if ($request->hasFile('logo')){
            $response = UploadFile::uploadFile($request->file('logo'), 'personel_images');
            $personel->image = $response["image"]["way"];
        }
        if ($personel->save()) {
            foreach ($dayList as $day){
                $restDay = new PersonelRestDay();
                $restDay->personel_id = $personel->id;
                $restDay->day_id = $day->id;
                $restDay->status = in_array($day->id, explode(',',$request->restDay)) ? 1 : 0;
                $restDay->save();
            }
            if (in_array('all', explode(',', $request->services))) {
                foreach ($business->services as $service) {
                    $personelService = new PersonelService();
                    $personelService->service_id = $service->id;
                    $personelService->personel_id = $personel->id;
                    $personelService->save();
                }
            } else {
                foreach (explode(',', $request->services) as $service) {
                    $personelService = new PersonelService();
                    $personelService->service_id = $service;
                    $personelService->personel_id = $personel->id;
                    $personelService->save();
                }
            }
            return response()->json([
                'status' => "success",
                'message' => "Personel Eklendi",
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Personel Eklenirken Bir Hata Oluştu Lütfen Tekrar Deneyin",
        ]);
    }

    /**
     * GET api/business/personal/add/get
     *
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3AddPersonalGet(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        return response()->json([
            'typeList' => BusinnessType::all(),
            'serviceCut' => ServiceCut::all(),
            'dayList' => DayList::all(),
            'appointmentRanges' => AppointmentRangeResource::collection(AppointmentRange::all()),
            'businessService' => BusinessServiceResource::collection($business->services),
        ]);
    }

    /**
     * POST api/personal/update
     *
     * Personel Güncelleme pointi
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> personal_id | required | numeric</li>
     * <li> name |required | string | personal adı</li>
     * <li> image |required | string | personel görseli</li>
     * <li> email |required | string | mail adresi</li>
     * <li> phone |required | string | telefon numarası</li>
     * <li> password |required | string | şifre</li>
     * <li> approveType |required | numeric | örneğin 1 veya 0</li>
     * <li> restDay |required | numeric | haftanın günlerinden herhangi bir günün id si</li>
     * <li> startTime |required | string | örneğin 10:43 </li>
     * <li> endTime |required | string | örneğin 10:43</li>
     * <li> foodStart |required | string | örneğin 10:43</li>
     * <li> foodEnd |required | string | örneğin 10:43</li>
     * <li> gender |required | numeric | 1 => kadın,2 => erkek,3 => Unisex herhangi biri</li>
     * <li> rate |required | numeric | 10 personel yüzdesi 10 = %10</li>
     * <li> appointmentRange |required | numeric | randevu aralığı örneğin "15" dk bazında</li>
     * <li> description |required | string</li>
     * <li> services | required | array | eğer tümü seçeneği seçilirse "all" olarak gönderebilirsiniz dizi içerisinde</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3UpdatePersonal(PersonalUpdateRequest $request)
    {
        if (count(explode(',',$request->services)) == 0){
            return response()->json([
                'status' => "error",
                'message' => "Eksik Alanlar Var",
                "errors" => [
                    "Hizmet Seçimi Yapmanız Gerekmektedir.",
                ]
            ]);
        }
        $user = $request->user();
        $business = Business::find($user->business_id);

        $personel = Personel::find($request->personal_id);
        if ($personel){
            $personel->name = $request->name;
            $personel->email = $request->email;
            $personel->password = Hash::make($request->password);
            $personel->phone = $request->phone;
            $personel->accepted_type = $request->approveType;
            $personel->accept = $request->accept;
           // $personel->rest_day = $request->restDay;
            $personel->start_time = $request->startTime;
            $personel->end_time = $request->endTime;
            $personel->food_start = $request->foodStart;
            $personel->food_end = $request->foodEnd;
            $personel->gender = $request->gender;
            $personel->rate = $request->rate;
            $personel->range = $request->appointmentRange;
            $personel->description = $request->description;
            if ($request->hasFile('logo')){
                $response = UploadFile::uploadFile($request->file('logo'), 'personel_images');
                $personel->image = $response["image"]["way"];
            }
            $dayList = DayList::all();
            if ($personel->save()) {
                $personel->restDays()->delete();
                foreach ($dayList as $day){
                    $restDay = new PersonelRestDay();
                    $restDay->personel_id = $personel->id;
                    $restDay->day_id = $day->id;
                    $restDay->status = in_array($day->id, explode(',',$request->restDay)) ? 1 : 0;
                    $restDay->save();
                }
                PersonelService::where('personel_id', $personel->id)->delete();
                if (in_array('all', explode(',', $request->services))) {
                    foreach ($business->services as $service) {
                        $personelService = new PersonelService();
                        $personelService->service_id = $service->id;
                        $personelService->personel_id = $personel->id;
                        $personelService->save();
                    }
                } else {
                    foreach (explode(',', $request->services) as $service) {
                        $personelService = new PersonelService();
                        $personelService->service_id = $service;
                        $personelService->personel_id = $personel->id;
                        $personelService->save();
                    }
                }
                return response()->json([
                    'status' => "success",
                    'message' => "Personel Güncellendi",
                ]);
            }
            return response()->json([
                'status' => "error",
                'message' => "Personel Güncellenirken Bir Hata Oluştu Lütfen Tekrar Deneyin",
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Personel Bulunamadı",
        ]);


    }

    /**
     * POST api/personal/get
     *
     * id si gönderilen personelin getirecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>personalId | required | güncellenecek personel id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3GetPersonal(Request $request)
    {
        $business = $request->user()->business;

        $personel = Personel::where('business_id', $business->id)->where('id', $request->personalId)->first();
        if ($personel) {
            return response()->json([
                'status' => "success",
                'message'=> "Personel Güncellendi",
                'personal' => PersonelResource::make($personel),
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Personel Bulunamadı",
            ]);
        }
    }

    /**
     * POST api/personal/get
     *
     * id si gönderilen personeli silecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li>personalId | required | silinecek personel id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function step3DeletePersonal(Request $request)
    {
        $personel = Personel::find($request->personalId);
        if ($personel) {
            $personel->delete();
            return response()->json([
                'status' => "success",
                'message' => "Personel Silindi",
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Personel Bulunamadı",
            ]);
        }
    }

}
