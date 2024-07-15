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
        return response()->json([
            'case' => $personel->case($request->listType, $request->start_date, $request->end_date),
            'payments' => MaasListResource::collection($personel->calculatePayedBalance()),
        ]);
    }

}