<?php

namespace App\Http\Controllers;

use App\Http\Resources\Customer\CashPointListResoruce;
use App\Models\Appointment;
use App\Models\CustomerCashPoint;
use Illuminate\Http\Request;

/**
 * @group Adisyonlar
 *
 */
class AdissionAddCashPointController extends Controller
{
    /**
     * Adisyon Parapuan Listesi
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index(Appointment $adission)
    {
        $customer = $adission->customer;
        return response()->json(CashPointListResoruce::collection($customer->cashPoints));
    }

    /**
     * Adisyon Parapuan Kullan
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function store(Appointment $adission, CustomerCashPoint $cashPoint)
    {
        $customer = $adission->customer;
        return response()->json(CashPointListResoruce::collection($customer->cashPoints));
    }
}
