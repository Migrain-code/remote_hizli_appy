<?php

namespace App\Http\Controllers\Absent;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\AbsentListResoruce;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Gelmeyen Müşteriler
 *
 */
class AbsentCustomerController extends Controller
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
     * Gelmeyen Müşteri Listesi
     *
     * <ul>
     * <li>15 Gün Gelmeyenler listType = 15 </li>
     * <li>30 Gün Gelmeyenler listType = 30 </li>
     * <li>60 Gün Gelmeyenler listType = 60 </li>
     * </ul>
     * @return JsonResponse
     *
     */
    public function index(Request $request)
    {
        $business = $this->business;
        $listType = 15;

        if ($request->filled('listType')) {
            $listType = $request->listType;
        }

        // 15 gün önceki tarihi alıyoruz
        $fifteenDaysAgo = Carbon::today()->subDays($listType);

        // İşletmeye ait randevuların müşterilerini ve son randevu tarihlerini alıyoruz
        $customers = Customer::whereIn('id', function ($query) use ($business) {
            $query->select('customer_id')
                ->from('appointments')
                ->where('business_id', $business->id);
        })
            ->whereHas('appointments', function ($query) use ($fifteenDaysAgo) {
                $query->where('start_time', '<', $fifteenDaysAgo);
            })
            ->with(['appointments' => function ($query) {
                $query->latest('start_time')->first();
            }])
            ->get();

        return response()->json(AbsentListResoruce::collection($customers));
    }

}
