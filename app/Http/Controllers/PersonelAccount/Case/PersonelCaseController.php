<?php

namespace App\Http\Controllers\PersonelAccount\Case;

use App\Http\Controllers\Controller;
use App\Http\Resources\Personel\MaasListResource;
use App\Models\Personel;
use Illuminate\Http\Request;

/**
 * @group Personel Kasa
 *
 */
class PersonelCaseController extends Controller
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
     * Personel Kasası
     *
     * listType değişkeninde gönderilecek
     * <ul>
     *     <li>yesterday</li>
     *     <li>thisWeek</li>
     *     <li>thisMonth</li>
     * </ul>
     * @param Personel $personel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function case(Request $request)
    {
        $personel = $this->personel;
        $appoinments = $personel->appointments()->when($request->filled('listType'), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('start_time', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('start_time', [$startOfYear, $endOfYear]);
            } else {
                $q->whereDate('start_time', now()->subDays(1)->toDateString());
            }
        })->get();
        $servicePrice = 0;
        foreach ($appoinments as $appointment) {
            $servicePrice += $appointment->service->price;
        }
        $hizmetHakedis = $servicePrice - ($servicePrice * $personel->rate) / 100;
        $productPrice = $personel->sales()->when($request->filled('listType'), function ($q) use ($request) {
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
                $q->whereDate('created_at', now()->subDays(1)->toDateString());
            }
        })->sum('total');

        $urunHakedis = $productPrice - (($productPrice * $personel->product_rate) / 100);

        return response()->json([
            'totalCiro' => number_format($servicePrice + $productPrice, 2),
            'progressPayment' => number_format($hizmetHakedis + $urunHakedis, 2),
            'balanceInside' => number_format($this->totalBalance($personel) - $this->calculatePayedBalance($personel)->sum('price'),  2),
            'balancePayed' => number_format($this->calculatePayedBalance($personel)->sum('price'), 2),
            'payments' => MaasListResource::collection($this->calculatePayedBalance($personel)),
        ]);
    }

    public function totalBalance($personel)
    {
        $productPrice = $personel->sales->sum('total');
        $servicePrice = 0;
        foreach ($personel->appointments as $appointment) {
            $servicePrice += $appointment->service->price;
        }
        $hizmetHakedis = $servicePrice - ($servicePrice * $personel->rate) / 100;
        $urunHakedis = $productPrice - (($productPrice * $personel->product_rate) / 100);

        return $hizmetHakedis + $urunHakedis;
    }

    public function calculatePayedBalance($personel)
    {
        $costs = $personel->costs()->where('cost_category_id', 1)->get();
        return $costs;
    }
}