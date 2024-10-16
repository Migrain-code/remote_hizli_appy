<?php

namespace App\Http\Controllers\PackageSale;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageSale\PackageSaleAddRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Customer\CustomerListResource;
use App\Http\Resources\PackageSale\PackageSaleDetailResource;
use App\Http\Resources\PackageSale\PackageSaleListResource;
use App\Http\Resources\Personel\PersonelListResource;
use App\Models\PackageSale;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group PackageSale
 *
 */
class PackageSaleController extends Controller
{
    /**
     * Paket Satış Listesi
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        $packages = $business->packages()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('seller_date', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('seller_date', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('seller_date', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('seller_date', now()->toDateString());
            }
        })->orderBy('seller_date', 'desc')->get();
        return response()->json(PackageSaleListResource::collection($packages));
    }

    /**
     * Paket Satış Ekleme
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $packageTypes = PackageSale::PACKAGE_TYPES;
        $customers = $business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
                });
            })
            ->take(30)->get();
        return response()->json([
            'customers' => CustomerListResource::collection($customers),
            'packageTypes' => $packageTypes,
            'businessServices' => BusinessServiceResource::collection($business->services),
            'personels' => PersonelListResource::collection($business->personels),
        ]);
    }

    /**
     * Paket Satış Oluşturma
     *
     * @param Request $request
     * @return Response
     */
    public function store(PackageSaleAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $packageSale = new PackageSale();
        $packageSale->business_id = $business->id;
        $packageSale->seller_date = $request->seller_date;
        $packageSale->customer_id = $request->input('customer_id');
        $packageSale->service_id = $request->input('service_id');
        $packageSale->type = $request->input('package_type');
        $packageSale->personel_id = $request->input('personel_id');
        $packageSale->amount = $request->input('amount');
        $packageSale->total = $request->total;
        if ($packageSale->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Satış Yapma İşlemi Eklendi"
            ]);
        }
    }

    /**
     * Paket Satışı Düzenleme
     *
     * @param PackageSale $packageSale
     * @return Response
     */
    public function edit(PackageSale $packageSale)
    {
        return response()->json(PackageSaleDetailResource::make($packageSale));
    }

    /**
     * Packet Satışı Güncelleme
     *
     * @param Request $request
     * @param PackageSale $packageSale
     * @return Response
     */
    public function update(PackageSaleAddRequest $request, PackageSale $packageSale)
    {
        $user = $request->user();
        $business = $user->business;

        $packageSale->business_id = $business->id;
        $packageSale->seller_date = $request->seller_date;
        $packageSale->customer_id = $request->input('customer_id');
        $packageSale->service_id = $request->input('service_id');
        $packageSale->type = $request->input('package_type');
        $packageSale->personel_id = $request->input('personel_id');
        $packageSale->amount = $request->input('amount');
        $packageSale->total = $request->total;
        if ($packageSale->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Satış Yapma İşlemi Güncellendi"
            ]);
        }
    }

    /**
     * Paket Satışı Silme
     *
     * @param PackageSale $packageSale
     * @return Response
     */
    public function destroy(PackageSale $packageSale)
    {
        if ($packageSale->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Satış Yapma İşlemine Ait Tüm Kayıtlar Silindi."
            ]);
        }
    }

}
