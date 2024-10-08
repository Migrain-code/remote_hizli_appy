<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Resources\Business\BusinessCategoryResource;
use App\Http\Resources\Business\BusinessPackageResource;
use App\Http\Resources\Business\BusinessResource;
use App\Http\Resources\Official\OfficialCardResource;
use App\Models\BusinessCategory;
use App\Models\BusinnessType;
use App\Models\BussinessPackage;
use App\Models\DayList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group Setup
 *
 */
class   SetupController extends Controller
{
    /**
     * GET api/setup
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * Kayıt Ekranı Tüm Bilgiler Apisi
     *
     *
     */
    public function get(Request $request)
    {
        $businessCategories = BusinessCategory::select('id', 'name')->get();
        $business_types = BusinnessType::select('id', 'name')->get();
        $dayList = DayList::orderBy('id', 'asc')->select('id', 'name')->get();
        $monthlyPackages = BussinessPackage::where('type', 0)->get();
        $yearlyPackages = BussinessPackage::where('type', 1)->get();
        $user = $request->user();
        $business = $user->business;

        return response()->json([
            'dayList' => $dayList,
            'businessTypes' => $business_types,
            'businessCategories' => BusinessCategoryResource::collection($businessCategories),
            'monthlyPackages' => BusinessPackageResource::collection($monthlyPackages),
            'yearlyPackages' => BusinessPackageResource::collection($yearlyPackages),
            'business' => BusinessResource::make($business),
            'cards' => OfficialCardResource::collection($user->cards),
            'aboutText' => "Salonumuza hoş geldiniz! Şıklığınıza, güzelliğinize ve saç bakımınıza özen gösteren profesyonel ekibimizle, sizlere en iyi hizmeti sunmak için buradayız.

Yılların tecrübesiyle, müşteri memnuniyetini ön planda tutarak, modern ve yenilikçi yaklaşımlarla saç kesimi, boyama, bakım ve makyaj hizmetleri sunuyoruz. Salonumuzda kullanılan tüm ürünler, en yüksek kalitede ve sağlığınıza zarar vermeyecek şekilde seçilmiştir.

Kendinize zaman ayırın ve uzmanlarımızın sihirli dokunuşlarıyla yenilenmiş bir görünüme kavuşun. Güler yüzlü personelimiz, rahat ve konforlu ortamımızla size keyifli bir deneyim sunmayı amaçlıyoruz. Sizin mutlu ayrılmanız, bizim en büyük ödülümüz.

Sizleri aramızda görmekten büyük mutluluk duyarız. Unutmayın, güzellik bir ayrıcalıktır ve bu ayrıcalığı yaşamak çok yakınızda.

Sevgilerimizle ,
".$business->name." Ekibi",
        ]);
    }

    /**
     * POST api/setup/update
     *
     *
     * <ul>
     * <li>Bearer Token | required | İşletme Kategorisi</li>
     * <li>category_id | string | required | İşletme Kategorisi</li>
     * <li>name | string | required | İşletme Adı</li>
     * <li>type_id | string | required | Hizmet Türü businessTypes değişkeninden alabilirsiniz </li>
     * <li>city_id  | string | required | Şehir</li>
     * <li>district_id  | string | required | İlçe</li>
     * <li>off_day_id  | string | required | Kapalı Olduğu Gün</li>
     * <li>phone | string | required | Kullanıcı Telefon Numarası</li>
     * <li>about_content | string | required| İşletme Hakkında Yazısı</li>
     * <li>start_time | string | required| İşletme Açılış Saati Örneğin (12:08)</li>
     * <li>end_time | string | required| İşletme Kapanış Saati Örneğin (18:08)</li>
     * <li>latitude | string | required| Haritadan seçilen lat bilgisi</li>
     * <li>longitude | string | required| Haritadan seçilen long bilgisi</li>
     * <li>address | text | required| Address Metni</li>
     * <li>package_id | integer or string | required| Seçili Paket idsi</li>
     * </ul>
     * Kayıt Ekranı Tüm Bilgiler güncelleme Apisi
     *
     *
     */
    public function update(Request $request)
    {
        $business = $request->user()->business;
        $business->category_id = $request->input('category_id');
        $business->appoinment_range = $request->input('appointmentRange');
        $business->name = $request->input('name');//business name
        $business->slug = Str::slug($request->input('name'));//business name
        $business->type_id = $request->input('type_id'); // business type
        $business->phone = $request->input('phone'); // business phone number
        $business->city = $request->input('city_id');
        $business->district = $request->input('district_id');
        $business->off_day = $request->input('off_day_id'); // close day
        $business->about = $request->input('about_content'); // about text
        $business->start_time = $request->input('start_time');
        $business->end_time = $request->input('end_time');
        //$business->address = $request->input('address');
        $business->lat = $request->input('latitude');
        $business->longitude = $request->input('longitude');
        //$business->package_id = $request->input('package_id');
        $business->setup_status = 1;
        $business->save();

        return response()->json([
            'status' => "success",
            'message' => "Bilgiler Kayıt Edildi",
        ]);
    }
}
