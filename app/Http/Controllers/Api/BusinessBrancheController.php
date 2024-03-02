<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branches\BranchAddRequest;
use App\Http\Resources\Branches\BusinessBrancesResource;
use App\Http\Resources\BusinessOfficial\BusinessOfficialListResource;
use App\Models\Business;
use App\Models\BusinessOfficial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group Şubeler
 *
 */
class BusinessBrancheController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            $this->user = auth()->user();
            return $next($request);
        });
    }
    /**
     * Şube Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Business::where("company_id", $this->business->company_id)->get();
        return response()->json(BusinessBrancesResource::collection($branches));
    }

    /**
     * Şube Oluştur
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $officials = BusinessOfficial::where("company_id", $this->business->company_id)->get();
        return response()->json(BusinessOfficialListResource::collection($officials));
    }

    /**
     * Şube Ekle
     *
     * @param  BranchAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BranchAddRequest $request)
    {
        if ($this->existBusiness(Str::slug($request->input('name')))){
            return response()->json([
                'status' => "success",
                'message' => "Bu İşletme Adı Daha Önce Kayıt Edilmiş. Lütfen Başka işletme adı ile giriş yapınız"
            ]);
        }
        $business = new Business();
        $business->name = $request->input('name');
        $business->slug = Str::slug($request->input('name'));
        $business->branch_name = $request->input('branchName');
        $business->company_id = $this->business->company_id;
        $business->package_id = 1;
        if ($business->save()){
            return response()->json([
               'status' => "success",
               'message' => "Şube Eklendi"
            ]);
        }
    }

    /**
     * Şube Değiştir
     *
     * Burada giriş yapan kullanıcının default şube bilgisi değişecek
     * @param  \Illuminate\Http\Request  $request
     * @param   Business $branche
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Business $branche)
    {
        if ($branche->id == $this->business->id){
            return response()->json([
                'status' => "error",
                'message' => "Aynı işletmedesiniz"
            ]);
        }
        else{
            $user = $this->user;
            $user->business_id = $branche->id;
            if ($user->save()){
                return response()->json([
                    'status' => "success",
                    'message' => $user->business->name . " İşletmesi Hesabına Geçtiniz",
                ]);
            }
        }
    }

    /**
     * Şube Sil
     *
     * @param  Business $branche
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $branche)
    {
        if ($branche->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Şube Silindi",
            ]);
        }
    }

    public function existBusiness($businessName)
    {
        return Business::where('slug', $businessName)->exists();
    }
}
