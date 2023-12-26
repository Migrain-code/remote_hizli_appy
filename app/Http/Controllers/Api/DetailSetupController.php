<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DetailSetupRequestStep1;
use App\Http\Resources\AppointmentRangeResource;
use App\Http\Resources\BusinessOfficialResource;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BusinessServiceResource;
use App\Http\Resources\PersonelResource;
use App\Http\Resources\ServiceCategoryResource;
use App\Models\AppointmentRange;
use App\Models\BusinessGallery;
use App\Models\BusinessService;
use App\Models\BusinessSlider;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelService;
use App\Models\ServiceCategory;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @group DetailSetup
 *
 */
class DetailSetupController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $commissions=[];
        for ($i = 0; $i <= 100; $i++){
             $commissions[]= [
                'id' => $i,
                'name' => "%". $i
             ];
        }
        return response()->json([
            'official' => BusinessOfficialResource::make($user),
            'dayList' => DayList::all(),
            'businessTypeList' => BusinnessType::all(),
            'appointmentRanges' => AppointmentRangeResource::collection(AppointmentRange::all()),
            'commissions' => $commissions,
            'aboutText' => "Test Mesaj",
        ]);
    }

    /**
     * POST api/detail-setup/step-1/update
     *
     *
     * <ul>
     * <li>Bearer Token</li>
     * <li>officialName | string | required | Salon Sahibinin adı</li>
     * <li>businessName | string | required | Salon Adı</li>
     * <li>offDay | numeric | required | kapalı olduğu günün id si </li>
     * <li>businessType | numeric | required | işletme türü id'si </li>
     * <li>cityId  | string | required | Şehir</li>
     * <li>districtId  | string | required | İlçe</li>
     * <li>phone | string | required | İşletme Telefon Numarası</li>
     * <li>email | string | required | İşletme E-posta Adresi</li>
     * <li>commission | string | required | P. Kredi kartı kesintisi | örneğin (10, 20, 30,40)</li>
     * <li>appointmentRange | string | required | Randevu aralığı | örneğin (10, 20, 30,40)</li>
     * <li>personalCount | string | required | Personel Sayısı | örneğin (1, 3, 5,10)</li>
     * <li>aboutText | string | required| İşletme Hakkında Yazısı</li>
     * <li>startTime | string | required| İşletme Açılış Saati Örneğin (12:08)</li>
     * <li>endTime | string | required| İşletme Kapanış Saati Örneğin (18:08)</li>
     * <li>year | date | required| Kuruluş Tarihi örneğin (2023-04-01)</li>
     * <li>address | text | required| Address Metni</li>
     * <li>logo | file | required| işletme logo</li>
     * <li>images | file | required| işletme görselleri</li>
     * </ul>
     * Detaylı Kurulum Ekranı İşletme Bilgileri güncelleme Apisi
     *
     *
     */
    public function step1(DetailSetupRequestStep1 $request)
    {
        $user = $request->user();
        $business = $user->business;

        $user->name = $request->input('officialName'); //Yetkili Ad Soyad
        $user->save();

        //$business->name = $request->input('businessName');// Salon Adı
        //$business->off_day = $request->input('offDay');
        $business->appoinment_range = $request->input('appointmentRange');
        //$business->type_id = $request->input('businessType');
        //$business->phone = $request->input('phone');
        //$business->start_time = $request->input('startTime');
        //$business->end_time = $request->input('endTime');
        $business->business_email = $request->input('email');
        $business->year = Carbon::parse($request->input('year'))->format('Y-m-d'); //2023-04-01
        $business->personal_count = $request->input('personalCount');
        $business->address = $request->input('address');
        $business->about = $request->input('aboutText');
        //$business->city = $request->input('cityId');
        //$business->district = $request->input('districtId');
        $business->commission = $request->input('commission');
        $business->save();

        return response()->json([
            'status' => "success",
            'message' => "İşletme Bilgileri Kayıt Edildi"
        ]);
    }

    /**
     * POST api/detail-setup/update/logo
     *
     * Bu işletmenin profil fotoğrafını güncelleyecek endpoint
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> base_64_code|text| notes: base 64 codunun başındaki data:image/jpeg;base64 kodunun olmaması gerekiyor </li>
     * <li> mime_type|string|image/png, image/jpeg, image/jpg olarak gönderilebilir </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function updateLogo(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $mime = $request->mime_type;
            if ($mime === 'image/png' or $mime === 'image/jpeg' or $mime === 'image/jpg') {
                if ($request->base_64_code) {
                    $newProfile = "data:image/jpeg;base64," . $request->base_64_code;
                    $data = explode(',', $newProfile);
                    $image = base64_decode($data[1]);
                    if ($mime)
                        $path = 'new_images/profiles/' . Str::random(64) . ".jpeg";
                    Storage::put($path, $image);
                    $user->image = $path;
                    if ($user->save()) {
                        return response()->json([
                            'status' => "success",
                            'message' => "Profiliniz Başarılı Bir Şekilde Güncellendi"
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => "warning",
                        'message' => "Profil Fotoğrafı Seçilmedi"
                    ]);
                }
            } else {
                return response()->json([
                    'status' => "warning",
                    'message' => "Sadece png, jpeg, jpg formatlarına izin veriliyor"
                ]);
            }


        }
        return response()->json(['error' => 'Unauthorized'], 401);

    }

    public function uploadLogo(Request $request)
    {
        //return $request->all();
        $user = $request->user()->business;
        if ($request->hasFile('logo')){
            $response = UploadFile::uploadFile($request->file('logo'), 'business_logo');

            $user->logo = $response["image"]["way"];
            $user->save();
            return response()->json([
                'status' => "success",
                'message' => "Logo Yüklendi",
                'link' => image($user->logo),
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Lütfen Bir Dosya Seçiniz",
            ]);
        }



    }

    public function uploadGallery(Request $request)
    {
        $user = $request->user()->business;

        if ($request->hasFile('images')){
            if ($user->gallery->count() == 1){

                $response = UploadFile::uploadFile($request->file('images'), 'business_wallpaper');
                $user->wallpaper = $response["image"]["way"];
                $user->save();
                $gallery = new BusinessGallery();
                $gallery->business_id = $user->id;
                $response = UploadFile::uploadFile($request->file('images'), 'businessGallery');
                $gallery->way = $response["image"]["way"];
                $gallery->byte = 45;
                $gallery->name = "businessGallery";
                $gallery->save();
            } else{
                $gallery = new BusinessGallery();
                $gallery->business_id = $user->id;
                $response = UploadFile::uploadFile($request->file('images'), 'businessGallery');
                $gallery->way = $response["image"]["way"];
                $gallery->byte = 45;
                $gallery->name = "businessGallery";
                $gallery->save();
            }

            return response()->json([
                'status' => "success",
                'message' => "İşletme Görseli Yüklendi.",
            ]);
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Lütfen Bir Görsel Seçiniz.",
            ]);
        }


    }

}
