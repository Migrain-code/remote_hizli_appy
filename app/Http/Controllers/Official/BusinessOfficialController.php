<?php

namespace App\Http\Controllers\Official;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessOfficial\BusinessOfficialAddRequest;
use App\Http\Resources\Branches\BusinessBrancesResource;
use App\Http\Resources\Business\BusinessOfficialResource;
use App\Models\Business;
use App\Models\BusinessOfficial;
use Illuminate\Support\Facades\Hash;

/**
 * @group BusinessOfficial
 *
 */
class BusinessOfficialController extends Controller
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
     * Yetkili Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(BusinessOfficialResource::collection($this->business->officials));
    }

    /**
     * Yetkili Oluşturma
     *
     * Burada yetkili oluşturmada kullanacağınız şube listesi dönecek
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $branches = Business::where("company_id", $this->business->company_id)->get();
        return response()->json(BusinessBrancesResource::collection($branches));
    }

    /**
     * Yetkili Ekleme
     *
     * branch_id şube seçiniz alnından seçilen şubenin idsi olacak
     * @param BusinessOfficialAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BusinessOfficialAddRequest $request)
    {
        if ($this->existEmail($request->input('email'))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu e-posta adresi ile kayıtlı yetkili bulunmakta"
            ]);
        }
        if ($this->existPhone(clearPhone($request->input('phone')))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu telefon numarası ile kayıtlı yetkili bulunmakta"
            ]);
        }
        $official = new BusinessOfficial();
        $official->name = $request->input('name');
        $official->phone = $request->input('phone');
        $official->email = $request->input('email');
        $official->password = Hash::make($request->input('password'));
        $official->business_id = $request->input('branch_id');
        if ($official->save()) {
            $official->company_id = $official->business->company_id;
            $official->save();
            return response()->json([
                'status' => "success",
                'message' => "Yetkili " . $official->business->name . " İşletmenize Eklendi"
            ]);
        }
    }

    /**
     * Yetkili Düzenle
     *
     * @param BusinessOfficial $official
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessOfficial $official)
    {
        $branches = Business::where("company_id", $this->business->company_id)->get();
        return response()->json([
            'official' => BusinessOfficialResource::make($official),
            'branches' => BusinessBrancesResource::collection($branches),
        ]);
    }

    /**
     * Yetkili Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param BusinessOfficial $official
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BusinessOfficialAddRequest $request, BusinessOfficial $official)
    {
        if ($official->email != $request->input('email') && $this->existEmail($request->input('email'))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu e-posta adresi ile kayıtlı yetkili bulunmakta"
            ]);
        }

        if ($official->phone != clearPhone($request->input('phone')) && $this->existPhone(clearPhone($request->input('phone')))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu telefon numarası ile kayıtlı yetkili bulunmakta"
            ]);
        }

        $official->name = $request->input('name');
        $official->phone = $request->input('phone');
        $official->email = $request->input('email');
        $official->password = Hash::make($request->input('password'));
        $official->business_id = $request->input('branch_id');
        if ($official->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Yetkili Güncellendi"
            ]);
        }
    }

    /**
     * Yetkili Silme
     *
     * @param BusinessOfficial $official
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessOfficial $official)
    {
        if ($official->is_admin == 1){
            return response()->json([
                'status' => "error",
                'message' => "Bu yetkili admin olduğu için hesabı silemezsiniz ancak bilgilerini güncelleyebilirsiniz."
            ]);
        }
        if ($official->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Yetkili Silindi"
            ]);
        }
    }

    public function existPhone($phone)
    {
        $existPhone = BusinessOfficial::where('phone', clearPhone($phone))->exists();
        if ($existPhone) {
            return true;
        } else {
            return false;
        }
    }

    public function existEmail($email)
    {
        $existPhone = BusinessOfficial::where('email', $email)->exists();
        if ($existPhone) {
            return true;
        } else {
            return false;
        }
    }
}
