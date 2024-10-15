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
     * <li>30-60 Gün Gelmeyenler listType = 30-60 </li>
     * <li>60 Gün Üstü Gelmeyenler listType = 60+ </li>
     * </ul>
     * @return JsonResponse
     *
     */
    public function index(Request $request)
    {
        $business = $this->business;
        $listType = '15';
        if ($request->filled('listType')) {
            $listType = $request->listType;
        }

        // Date ranges
        $today = Carbon::today();
        switch ($listType) {
            case '15':
                $startDate = $today->subDays(15);
                $endDate = $today;
                break;
            case '30':
                $startDate = $today->subDays(30);
                $endDate = $today->subDays(15);
                break;
            case '60+':
                $startDate = null;
                $endDate = $today->subDays(60);
                break;
            default:
                return response()->json(['error' => 'Invalid listType'], 400);
        }

        // Müşterileri filtreleme
        $customersQuery = Customer::whereIn('id', function ($query) use ($business) {
            $query->select('customer_id')
                ->from('appointments')
                ->where('business_id', $business->id);
        });

        // Tarih aralıklarına göre filtreleme
        if ($listType === '60+') {
            $customersQuery->whereDoesntHave('appointments', function ($query) use ($endDate) {
                $query->where('start_time', '>=', $endDate);
            });
        } else {
            $customersQuery->whereDoesntHave('appointments', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_time', [$startDate, $endDate]);
            });
        }

        $customers = $customersQuery->with(['appointments' => function ($query) {
            $query->latest('start_time');
        }])->get();

        return response()->json(AbsentListResoruce::collection($customers));
    }


}
