<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Resources\Business\BusinessPackageResource;
use Illuminate\Http\JsonResponse;

/**
 * @group Üyelik
 *
 */
class SubscribtionController extends Controller
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
     * Abonelik Özeti
     * @return JsonResponse
     *
     */
    public function index()
    {
        //$business = $this->business;
        $terms = setting("appy_terms");
        return response()->json([
            'remaining_day' => now()->diffInDays($this->business->packet_end_date),
            'package' => BusinessPackageResource::make($this->business->package),
            'termsAndConditions' => $terms
        ]);
    }
}
