<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CustomerCommentListResource;
use App\Http\Resources\Customer\CashPointList2Resoruce;
use App\Http\Resources\PackageSale\CustomerPackageSaleListResource;
use App\Http\Resources\ProductSale\CustomerProductSaleListResource;
use App\Http\Resources\Receivable\ReceivableListResource;
use App\Models\AppointmentCollectionEntry;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Customer Info
 *
 */
class CustomerInfoController extends Controller
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
     * Parapuan Listesi
     *
     * @return JsonResponse
     */
    public function cashPointList(Customer $customer)
    {
        return response()->json([
            'total' => $customer->cashPoints->count(),
            'cashPoints' => CashPointList2Resoruce::collection($customer->allCashPoints)
        ]);
    }
    /**
     * Ürün Satış Listesi
     *
     * @return JsonResponse
     */
    public function productSaleList(Customer $customer, Request $request)
    {
        $productSales = $customer->productSales()->where('business_id', $this->business->id)
            ->when($request->filled('listType'), function ($q) use ($request) {
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
            })->get();
        return response()->json(CustomerProductSaleListResource::collection($productSales));
    }

    /**
     * Ürün Satış Listesi
     *
     * @return JsonResponse
     */
    public function packageSaleList(Customer $customer, Request $request)
    {
        $packageSales = $customer->packageSales()->where('business_id', $this->business->id)
            ->when($request->filled('listType'), function ($q) use ($request) {
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
            })->get();
        return response()->json(CustomerPackageSaleListResource::collection($packageSales));
    }

    /**
     * Borçları
     *
     * @return JsonResponse
     */
    public function receivableList(Customer $customer)
    {
        $receivables = $customer->deps()->where('business_id', $this->business->id)->get();
        return response()->json(ReceivableListResource::collection($receivables));
    }
    /**
     * Yorumları
     *
     * @return JsonResponse
     */
    public function comments(Customer $customer)
    {
        $comments = $customer->comments()->where('business_id', $this->business->id)->get();

        return response()->json(CustomerCommentListResource::collection($comments));
    }
    /**
     * Ödemeleri
     *
     * @return JsonResponse
     */
    public function payments(Customer $customer)
    {
        $payments = [];
        $packageSales = $customer->packageSales()->where('business_id', $this->business->id)->get();
        foreach ($packageSales as $packageSale){
            foreach ($packageSale->payeds as $payed){
                $payments[] = [
                    "id" => $payed->package_id,
                    "price" => $payed->price,
                    "amount" => $payed->amount,
                    "type" => "Paket Ödemesi",
                    "created_at" => $payed->created_at->format('d.m.Y H:i:s')
                ];
            }
        }

        $appointmentIds = $customer->appointments()->has('payments')->pluck('id')->toArray();
        $appointmentPayed = AppointmentCollectionEntry::whereIn('appointment_id', $appointmentIds)->get();
        foreach ($appointmentPayed as $payed){
            $payments[] = [
                "id" => $payed->appointment_id,
                "price" => $payed->price,
                "amount" => 1,
                "type" => "Adisyon Tahsilat Ödemesi",
                "created_at" => $payed->created_at->format('d.m.Y H:i:s')
            ];
        }

        return response()->json($this->sortedCreatedAt($payments));
    }

    public function sortedCreatedAt($data) // tarihe göre sırala yeniden eskiye
    {
        usort($data, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $data;
    }
}
