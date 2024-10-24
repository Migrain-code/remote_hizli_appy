<?php

namespace App\Http\Controllers\Case;

use App\Http\Controllers\Controller;
use App\Models\PackagePayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            //'closedTotal' => 0,
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
        if (!isset($request->date_range)){
            if (!$request->filled('min_date') && !$request->filled('max_date')) {
                $request->merge(['date_range' => now()->format('d.m.Y') . ' - ' . now()->format('d.m.Y')]);
            } else{
                $request->merge(["date_range" => Carbon::parse($request->min_date)->format('d.m.Y'). ' - ' .Carbon::parse($request->max_date)->format('d.m.Y')]);
            }
        }


        $adissionTotal = $this->adissionCalculator($business, $request);
        $productSaleTotal = $this->productSaleCalculator($business, $request);
        $this->paymentsCalculator($business, $request);
        $packageSaleTotal = $this->packageSaleCalculator($business, $request);

        $closingBalance = $this->case;
        $totalExpense = $this->payments;
        $totals = [
            'total' => $this->case["total"] - $this->payments["total"],
            'cashTotal' => $this->case["cashTotal"] - $this->payments["cashTotal"],
            'creditTotal' => $this->case["creditTotal"] - $this->payments["creditTotal"],
            'eftTotal' => $this->case["eftTotal"] - $this->payments["eftTotal"],
            'otherTotal' => $this->case["otherTotal"] - $this->payments["otherTotal"]
        ];

        return response()->json([
            'remainingTotal' => $totals,
            'expense' => $totalExpense,
            'revenues' => $closingBalance,
            'adissionTotal' => $adissionTotal,
            'productSaleTotal' => $productSaleTotal,
            'packageSaleTotal' => $packageSaleTotal,
        ]);
    }

    public function adissionCalculator($business, $request)
    {
        $adissions = $business->appointments()->whereIn('status', [2, 5, 6])
            ->when($request->filled('date_range'), function ($q) use ($request) {
                $timePartition = explode('-', $request->date_range);
                $startTime = Carbon::createFromFormat('d.m.Y', trim($timePartition[0]))->startOfDay();
                $endTime = Carbon::createFromFormat('d.m.Y', trim($timePartition[1]))->endOfDay();

                if ($startTime == $endTime){
                    $q->whereDate('start_time', $startTime);
                } else{
                    $q->whereBetween('start_time', [$startTime, $endTime]);
                }
            })
            ->get();

        $adissionTotal = [
            'cashTotal' => 0,
            'creditTotal' => 0,
            'eftTotal' => 0,
            'otherTotal' => 0,
            'total' => 0
        ];

        foreach ($adissions as $adission) {
            foreach ($adission->payments as $payment) {
                if ($payment->payment_type_id == 0) {
                    $this->case["cashTotal"] += $payment->price;
                    $adissionTotal["cashTotal"] += $payment->price;
                } elseif ($payment->payment_type_id == 1) {
                    $this->case["creditTotal"] += $payment->price;
                    $adissionTotal["creditTotal"] += $payment->price;
                } elseif ($payment->payment_type_id == 2) {
                    $this->case["eftTotal"] += $payment->price;
                    $adissionTotal["eftTotal"] += $payment->price;
                } else {
                    $this->case["otherTotal"] += $payment->price;
                    $adissionTotal["otherTotal"] += $payment->price;
                }
            }

        }

        $this->case["total"] = $this->case["cashTotal"] + $this->case["creditTotal"] + $this->case["eftTotal"] + $this->case["otherTotal"];
        $adissionTotal["total"] = $adissionTotal["cashTotal"] + $adissionTotal["creditTotal"] + $adissionTotal["eftTotal"] + $adissionTotal["otherTotal"];

        return $adissionTotal;
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
            })
            ->when($request->filled('date_range'), function ($q) use ($request) {
                $startTime = now();
                $endTime = now();
                if ($request->filled('date_range')) {
                    $timePartition = explode('-', $request->date_range);
                    $startTime = Carbon::parse(clearPhone($timePartition[0]))->toDateString();
                    $endTime = Carbon::parse(clearPhone($timePartition[1]))->toDateString();
                }
                $q->whereBetween('created_at', [$startTime, $endTime]);
            })
            ->get();
        $productSaleTotal = [
            'cashTotal' => 0,
            'creditTotal' => 0,
            'eftTotal' => 0,
            'otherTotal' => 0,
            'total' => 0
        ];

        foreach ($sales as $sale) {
            if ($sale->payment_type == 0) {
                $this->case["cashTotal"] += $sale->total;
                $productSaleTotal["cashTotal"] += $sale->total;

            } elseif ($sale->payment_type == 1) {
                $this->case["creditTotal"] += $sale->total;
                $productSaleTotal["creditTotal"] += $sale->total;

            } elseif ($sale->payment_type == 2) {
                $this->case["eftTotal"] += $sale->total;
                $productSaleTotal["eftTotal"] += $sale->total;

            } else {
                $this->case["otherTotal"] += $sale->total;
                $productSaleTotal["otherTotal"] += $sale->total;
            }
        }
        $this->case["total"] = $this->case["cashTotal"] + $this->case["creditTotal"] + $this->case["eftTotal"] + $this->case["otherTotal"];
        $productSaleTotal["total"] = $productSaleTotal["cashTotal"] + $productSaleTotal["creditTotal"] + $productSaleTotal["eftTotal"] + $productSaleTotal["otherTotal"];

        return $productSaleTotal;
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
            })
            ->when($request->filled('date_range'), function ($q) use ($request) {
                $startTime = now();
                $endTime = now();
                if ($request->filled('date_range')) {
                    $timePartition = explode('-', $request->date_range);
                    $startTime = Carbon::parse(clearPhone($timePartition[0]))->toDateString();
                    $endTime = Carbon::parse(clearPhone($timePartition[1]))->toDateString();
                }
                $q->whereBetween('operation_date', [$startTime, $endTime]);
            })
            ->get();

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

    public function packageSaleCalculator($business, $request)
    {
        $packageSales = $business->packages()
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
            })
            ->when($request->filled('date_range'), function ($q) use ($request) {
                $startTime = now();
                $endTime = now();
                if ($request->filled('date_range')) {
                    $timePartition = explode('-', $request->date_range);
                    $startTime = Carbon::parse(clearPhone($timePartition[0]))->toDateString();
                    $endTime = Carbon::parse(clearPhone($timePartition[1]))->toDateString();
                }
                $q->whereBetween('created_at', [$startTime, $endTime]);
            })
            ->get();
        $packageSaleTotal = [
            'cashTotal' => 0,
            'creditTotal' => 0,
            'eftTotal' => 0,
            'otherTotal' => 0,
            'total' => 0
        ];

        foreach ($packageSales as $packageSale) {
            foreach ($packageSale->payeds as $payment) {

                if ($payment->payment_type == 0) {
                    $this->case["cashTotal"] += $payment->price;
                    $packageSaleTotal["cashTotal"] += $payment->price;

                } elseif ($payment->payment_type == 1) {
                    $this->case["creditTotal"] += $payment->price;
                    $packageSaleTotal["creditTotal"] += $payment->price;

                } elseif ($payment->payment_type == 2) {
                    $this->case["eftTotal"] += $payment->price;
                    $packageSaleTotal["eftTotal"] += $payment->price;

                } else {
                    $this->case["otherTotal"] += $payment->price;
                    $packageSaleTotal["otherTotal"] += $payment->price;
                }
            }
        }

        $this->case["total"] = $this->case["cashTotal"] + $this->case["creditTotal"] + $this->case["eftTotal"] + $this->case["otherTotal"];
        $packageSaleTotal["total"] = $packageSaleTotal["cashTotal"] + $packageSaleTotal["creditTotal"] + $packageSaleTotal["eftTotal"] + $packageSaleTotal["otherTotal"];

        return $packageSaleTotal;
    }


}
