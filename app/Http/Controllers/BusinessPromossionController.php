<?php

namespace App\Http\Controllers;

use App\Http\Resources\Promosion\PromossionListResource;
use App\Models\BusinessPromossion;
use Illuminate\Http\Request;

/**
 * @group Promosyonlar
 *
 */
class BusinessPromossionController extends Controller
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
     * Promosyon Listesi
     *
     * Burada işletmenin promosyon listesi dönecek. 1-100 arasında seçim alanlarında mobilde
     * değer üretilip apiden gelen rate verisine göre selected attribute aktif edilecek
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promossions = $this->business->promossions;

        return response()->json(PromossionListResource::collection($promossions));
    }

    /**
     * Promosyon Listesi Güncelleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessPromossion  $businessPromossion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessPromossion $businessPromossion)
    {
        $this->business->promossions()->delete();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessPromossion  $businessPromossion
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessPromossion $businessPromossion)
    {
        //
    }
}
