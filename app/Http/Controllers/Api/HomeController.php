<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group BusinessHome
 *
 * */
class HomeController extends Controller
{
    /**
     * İşletme anasayfa apisi
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        return response()->json([
            'appointmentCount' => "5",
            'productSale' => "150",
            'adisyonCount' => "56",
            'totalCount' => "240",
            'newCustomerCount' => "500",
            'totalCustomerCount' => "750",
        ]);

    }
}
