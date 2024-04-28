<?php

namespace App\Http\Controllers\PersonelAccount\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personel\PersonalUpdateRequest;
use App\Http\Requests\PersonelAccount\PersonalLoginRequest;
use App\Http\Requests\PersonelAccount\PersonalProfileUpdateRequest;
use App\Http\Resources\Appointment\AppointmentRangeResource;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Location\DayListResource;
use App\Http\Resources\Personel\PersonelResource;
use App\Http\Resources\PersonelAccount\AccountResource;
use App\Models\AppointmentRange;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelRestDay;
use App\Models\PersonelService;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Personel Hesabı
 *
 */
class PersonalProfileUpdateController extends Controller
{
    private $personel;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->personel = auth('personel')->user();
            return $next($request);
        });
    }

    /**
     * Profil Bilgileri
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(AccountResource::make($this->personel));
    }
    /**
     * Profil Oluşturma
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        return response()->json([
            'dayList' => DayListResource::collection(DayList::all()),
            'appointmentRanges' => AppointmentRangeResource::collection(AppointmentRange::all()),
            'services' => BusinessServiceResource::collection($this->personel->business->services),
        ]);
    }
    /**
     * Profil Güncelle
     *
     * @param PersonalProfileUpdateRequest $request
     * @param Personel $personel
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PersonalProfileUpdateRequest $request)
    {
        $personel = $this->personel;
        if ($request->filled('password') && isset($request->password)) {
            $personel->password = Hash::make($request->password);
        }
        $personel->name = $request->input('name');
        $personel->email = $request->email;
        $personel->phone = $request->phone;
        $personel->accepted_type = $request->approveType;
        $personel->accept = $request->accept;
        $personel->start_time = $request->startTime;
        $personel->end_time = $request->endTime;
        $personel->food_start = $request->foodStart;
        $personel->food_end = $request->foodEnd;
        //$personel->gender = $request->gender;
        //$personel->rate = $request->rate;
        $personel->range = $request->appointmentRange;
        $personel->description = $request->description;

        $dayList = DayList::all();

        if ($request->hasFile('logo')) {
            $response = UploadFile::uploadFile($request->file('logo'), 'personel_images');
            $personel->image = $response["image"]["way"];
        }
        if ($personel->save()) {
            foreach ($dayList as $day) {
                $restDay = new PersonelRestDay();
                $restDay->personel_id = $personel->id;
                $restDay->day_id = $day->id;
                $restDay->status = in_array($day->id, explode(',', $request->restDay)) ? 1 : 0;
                $restDay->save();
            }

            return response()->json([
                'status' => "success",
                'message' => "Kullanıcı Bilgileriniz Güncellendi.",
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Güncelleme Yapılırken Bir Hata Oluştu Lütfen Tekrar Deneyin",
        ]);
    }
}
