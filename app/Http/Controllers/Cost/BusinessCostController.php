<?php

namespace App\Http\Controllers\Cost;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cost\CostAddRequest;
use App\Http\Resources\Cost\CostCategoryListResource;
use App\Http\Resources\Cost\CostEditResource;
use App\Http\Resources\Cost\CostListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Models\BusinessCost;
use App\Models\CostCategory;
use Illuminate\Http\Request;

/**
 * @group Masraflar
 *
 */
class BusinessCostController extends Controller
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
     * Masraflar Listesi
     * Default Tümü
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $costs = $this->business->costs()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('created_at', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('created_at', now()->toDateString());
            }
        })->latest()->get();
        return response()->json(CostListResource::collection($costs));
    }

    /**
     * Masraf Oluşturma
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json([
            'personels' => PersonelListResource::collection($this->business->personels),
            'paymentTypes' => BusinessCost::PAYMENT_TYPES,
            'costCategories' => CostCategoryListResource::collection(CostCategory::all()),
        ]);
    }

    /**
     * Masraf Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CostAddRequest $request)
    {
        $businessCost = new BusinessCost();
        $this->extracted($businessCost, $request);

        if ($businessCost->save()){
            return response()->json([
               'status' => "success",
               'message' => "Masraf Başarılı Bir Şekilde Eklendi",
            ]);
        }
    }

    /**
     * Masraf Düzenleme
     *
     * @param  \App\Models\BusinessCost  $cost
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(BusinessCost $cost)
    {
        return response()->json(CostEditResource::make($cost));
    }

    /**
     * Masraf Güncelleme
     *
     * @param  CostAddRequest  $request
     * @param  BusinessCost  $cost
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CostAddRequest $request, BusinessCost $cost)
    {
        $this->extracted($cost, $request);

        if ($cost->save()){
            return response()->json([
                'status' => "success",
                'message' => "Masraf Başarılı Bir Şekilde Güncellendi",
            ]);
        }
    }

    /**
     * Masraf Silme
     *
     * @param  \App\Models\BusinessCost  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessCost $cost)
    {
        if ($cost->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Masraf Başarılı Bir Şekilde Silindi",
            ]);
        }
    }

    /**
     * @param BusinessCost $cost
     * @param CostAddRequest $request
     * @return void
     */
    public function extracted(BusinessCost $cost, CostAddRequest $request): void
    {
        $cost->business_id = $this->business->id;
        $cost->cost_category_id = $request->costCategoryId;
        $cost->personel_id = $request->personelId;
        $cost->payment_type_id = $request->paymentTypeId;
        $cost->price = $request->price;
        $cost->operation_date = $request->operationDate;
        $cost->description = $request->description;
        $cost->note = $request->note;
    }
}
