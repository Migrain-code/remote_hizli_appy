<?php

namespace App\Http\Controllers;

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
        if ($request->filled('listType')){
            $listType = $request->listType;
        }
        $today = Carbon::today();

        // 15 gün önceki tarihi alıyoruz
        $fifteenDaysAgo = $today->copy()->subDays($listType);


        // Tüm randevuları alıyoruz
        $appointmentsCustomer = $business->appointments()->pluck('customer_id')->toArray();
        $customers = array_unique($appointmentsCustomer);

        $customerList = [];

        foreach ($customers as $customerId) {
            // Müşteriye ait son randevunun tarihini alıyoruz
            $customer = Customer::find($customerId);
            if ($customer){
                $lastAppointment = $customer->appointments()->latest('start_time')->first();
                $lastAppointmentDate = $lastAppointment->start_time;

                if ($lastAppointmentDate->lessThan($fifteenDaysAgo)) {
                    $customerList[] = $customer;
                }
            }
        }

        return  response()->json(AbsentListResoruce::collection($customerList));
    }
}
