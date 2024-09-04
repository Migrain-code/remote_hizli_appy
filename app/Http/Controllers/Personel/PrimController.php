<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Resources\Personel\PersonelListResource;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Prim
 *
 */
class PrimController extends Controller
{
    private $business;

    private $case;

    public function __construct()
    {
        $this->case = [
            'servicePrice' => 0,
            'productPrice' => 0,
            'total' => 0,
        ];
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $startTime = now();
        $endTime = now();
        if ($request->filled('min_date') && $request->filled('max_date')){
            $startTime = Carbon::parse($request->min_date)->toDateString();
            $endTime = Carbon::parse($request->max_date)->toDateString();
        }

        $personels = $this->business->personels;
        if ($request->filled('personel_id')){
            $personel = Personel::find($request->personel_id);
        } else{
            $personel = $personels->first();
        }

        $case = $personel->case(null, $startTime, $endTime);

        return response()->json([
           'case' => $case,
           'selected_personel' => PersonelListResource::make($personel),
           'personels' => PersonelListResource::collection($personels),
        ]);
    }
}
