<?php

namespace App\Http\Controllers\Case;

use App\Http\Controllers\Controller;
use App\Models\PackagePayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Kasa
 *
 */
class CaseController extends Controller
{
    private $business;

    private $case;

    private $payments;

    public function __construct()
    {
        $this->case = [
            'closedTotal' => 0,
            'total' => 0,
            'cashTotal' => 0,
            'creditTotal' => 0,
            'eftTotal' => 0,
            'otherTotal' => 0,
        ];

        $this->payments = [
            'total' => 0,
            'cashTotal' => 0,
            'creditTotal' => 0,
            'eftTotal' => 0,
            'otherTotal' => 0,
        ];
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    /**
     * Kasa Liste
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $business = $this->business;

        $this->adissionCalculator($business, $request);
        $this->productSaleCalculator($business, $request);
        $this->paymentsCalculator($business, $request);
        return response()->json([
            'closingBalance' => $this->case,
            'totalExpense' => $this->payments
        ]);
    }

    public function adissionCalculator($business, $request)
    {
        $adissions = $business->appointments()->whereIn('status', [5, 6])->when($request->filled('listType'), function ($q) use ($request) {
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
                $q->whereDate('start_time', now()->toDateString());
            }
        })->get();

        foreach ($adissions as $adission) {
            foreach ($adission->payments as $payment) {
                if ($payment->payment_type_id == 0) {
                    $this->case["cashTotal"] += $payment->price;
                } elseif ($payment->payment_type_id == 1) {
                    $this->case["creditTotal"] += $payment->price;
                } elseif ($payment->payment_type_id == 2) {
                    $this->case["eftTotal"] += $payment->price;
                } else {
                    $this->case["otherTotal"] += $payment->price;
                }
            }

        }
        $this->case["total"] = $this->case["cashTotal"] + $this->case["creditTotal"] + $this->case["eftTotal"] + $this->case["otherTotal"];
        return $this->case;
    }

    public function productSaleCalculator($business, $request)
    {
        $sales = $business->sales()
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

        foreach ($sales as $sale) {
            if ($sale->payment_type == 0) {
                $this->case["cashTotal"] += $sale->total;
            } elseif ($sale->payment_type == 1) {
                $this->case["creditTotal"] += $sale->total;
            } elseif ($sale->payment_type == 2) {
                $this->case["eftTotal"] += $sale->total;
            } else {
                $this->case["otherTotal"] += $sale->total;
            }
        }
        $this->case["total"] = $this->case["cashTotal"] + $this->case["creditTotal"] + $this->case["eftTotal"] + $this->case["otherTotal"];

        return $this->case;
    }

    public function packagePaymentCalculator($business, $request)
    {
        $packageIds = $business->packages()->pluck('id')->toArray();
        $packagePayments = PackagePayment::whereIn('package_id', [$packageIds])->when($request->filled('listType'), function ($q) use ($request) {
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
        })->sum('price');
        $this->case["cashTotal"] += $packagePayments;
        $this->case["total"] += $this->case["cashTotal"];
        return $this->case;
    }

    public function paymentsCalculator($business, $request)
    {
        $costs = $business->costs()
            ->when($request->filled('listType'), function ($q) use ($request) {
                if ($request->listType == "thisWeek") {
                    $startOfWeek = now()->startOfWeek();
                    $endOfWeek = now()->endOfWeek();
                    $q->whereBetween('operation_date', [$startOfWeek, $endOfWeek]);
                } elseif ($request->listType == "thisMonth") {
                    $startOfMonth = now()->startOfMonth();
                    $endOfMonth = now()->endOfMonth();
                    $q->whereBetween('operation_date', [$startOfMonth, $endOfMonth]);
                } elseif ($request->listType == "thisYear") {
                    $startOfYear = now()->startOfYear();
                    $endOfYear = now()->endOfYear();
                    $q->whereBetween('operation_date', [$startOfYear, $endOfYear]);
                } else {
                    $q->whereDate('operation_date', now()->toDateString());
                }
            })->get();

        foreach ($costs as $cost) {
            if ($cost->payment_type_id == 0) {
                $this->payments["cashTotal"] += $cost->price;
            } elseif ($cost->payment_type_id == 1) {
                $this->payments["creditTotal"] += $cost->price;
            } elseif ($cost->payment_type_id == 2) {
                $this->payments["eftTotal"] += $cost->price;
            } else {
                $this->payments["otherTotal"] += $cost->price;
            }
        }
        $this->payments["total"] = $this->payments["cashTotal"] + $this->payments["creditTotal"] + $this->payments["eftTotal"] + $this->payments["otherTotal"];

        return $this->payments;
    }
}
