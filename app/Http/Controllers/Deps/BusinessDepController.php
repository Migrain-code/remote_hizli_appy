<?php

namespace App\Http\Controllers\Deps;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessDep\DepListAddRequest;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\Dept\DeptResource;
use App\Models\BusinessDep;
use Illuminate\Http\Request;

/**
 * @group Borçlar
 *
 */
class BusinessDepController extends Controller
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
     * Borç Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(DeptResource::collection($this->business->depts));
    }

    /**
     * Borç Oluşturma
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $customers = $this->business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
                });
            })->take(30)->get();
        return response()->json(CustomerListResource::collection($customers));
    }

    /**
     * Borç Ekleme
     *
     * @param DepListAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DepListAddRequest $request)
    {
        $businessDep = new BusinessDep();
        $this->extracted($businessDep, $request);
        return response()->json([
            'status' => "success",
            'message' => "Borç Başarılı Bir Şekilde Eklendi"
        ]);
    }

    /**
     * Borç Detayı
     *
     * @param \App\Models\BusinessDep $dep
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BusinessDep $dep)
    {
        return response()->json(DeptResource::make($dep));
    }

    /**
     * Borç Düzenleme
     *
     * @param \App\Models\BusinessDep $dep
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(BusinessDep $dep)
    {
        return response()->json(DeptResource::make($dep));
    }

    /**
     * Borç Güncelleme
     *
     * @param DepListAddRequest $request
     * @param BusinessDep $dep
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DepListAddRequest $request, BusinessDep $dep)
    {
        $this->extracted($dep, $request);
        return response()->json([
            'status' => "success",
            'message' => "Borç Başarılı Bir Şekilde Güncellendi"
        ]);
    }

    /**
     * Borç Silme
     *
     * @param \App\Models\BusinessDep $dep
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BusinessDep $dep)
    {
        if ($dep->delete()) return response()->json([
            'status' => "success",
            'message' => "Borç Başarılı Bir Şekilde Silindi"
        ]);
    }

    public function pay(BusinessDep $dep)
    {
        $dep->price = 0;
        if ($dep->save()) return response()->json([
            'status' => "success",
            'message' => "Borç Başarılı Bir Şekilde Ödendi Olarak Güncellendi"
        ]);
    }
    public function extracted($businessDep, $request): void
    {
        $businessDep->business_id = $this->business->id;
        $businessDep->customer_id = $request->customerId;
        $businessDep->payment_date = $request->paymentDate;
        $businessDep->price = $request->price;
        $businessDep->note = $request->note;
        $businessDep->save();
    }

}
