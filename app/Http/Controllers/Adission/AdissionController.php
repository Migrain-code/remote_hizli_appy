<?php

namespace App\Http\Controllers\Adission;

use App\Http\Controllers\Controller;
use App\Http\Resources\Appointment\AppointmentDetailResoruce;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Adisyonlar
 *
 */
class AdissionController extends Controller
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
     * Adisyonlar Listesi
     *
     * @return \Illuminate\Http\Response
     */

    private const OPEN_STATUS = [2];//açık
    private const CLOSED_STATUS = [5, 6];//kapatılmış
    private const CANCELED_STATUS = [3, 4];//iptal edilmiş
    private const DEFAULT_STATUS = [2];//default açık
    private const ALLSTATUS = [2, 3, 4, 5, 6];

    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $this->handleDateRange($request);

        $appointments = $business->appointments()
            ->when($request->filled('listType'), fn($q) => $this->applyListTypeFilter($q, $request->listType))
            ->when($request->filled('date_range'), fn($q) => $this->applyDateRangeFilter($q, $request->date_range))
            ->when(!$request->filled('listType'), function ($q) use ($request) {
                $q->whereIn('status', self::ALLSTATUS);
            })
            ->latest()
            ->take(30)
            ->get();

        return response()->json(AppointmentResource::collection($appointments));
    }

    private function handleDateRange(Request $request): void
    {
        if (!isset($request->date_range)) {
            if (!$request->filled('start_date') && !$request->filled('end_date')) {
                $request->merge(['date_range' => now()->format('d.m.Y') . ' - ' . now()->format('d.m.Y')]);
            } else {
                $request->merge([
                    'date_range' => Carbon::parse($request->start_date)->format('d.m.Y') . ' - ' . Carbon::parse($request->end_date)->format('d.m.Y')
                ]);
            }
        }
    }

    private function applyListTypeFilter($query, string $listType)
    {
        $statusMap = [
            'open' => self::OPEN_STATUS,
            'closed' => self::CLOSED_STATUS,
            'canceled' => self::CANCELED_STATUS,
            'default' => self::DEFAULT_STATUS
        ];

        $statuses = $statusMap[$listType] ?? [];
        return empty($statuses) ? $query->whereNotIn('status', [0])->whereIn('status', self::DEFAULT_STATUS)
            : $query->whereIn('status', $statuses);
    }

    private function applyDateRangeFilter($query, string $dateRange)
    {
        [$startTime, $endTime] = array_map(fn($date) => Carbon::parse(clearPhone(trim($date)))->toDateString(), explode('-', $dateRange));
        return $query->whereBetween('start_time', [$startTime, $endTime]);
    }


    /**
     * Adisyon Detayı
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Appointment $adission)
    {
        return response()->json(AppointmentDetailResoruce::make($adission));
    }

    /**
     * Adisyon gelmedi
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $adission)
    {
        $adission->status = 4;
        $adission->save();
        foreach ($adission->services as $service) {
            $service->status = 4;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Adisyon durumu güncellendi"
        ]);
    }

    /**
     * Adisyon Geldi
     *
     * @param \Illuminate\Http\Request $request
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $adission)
    {
        $adission->status = 5;
        $adission->save();
        foreach ($adission->services as $service) {
            $service->status = 5;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Adisyon durumu güncellendi"
        ]);
    }

    /**
     * Adisyon İptal Et
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $adission)
    {
        $adission->status = 3;
        $adission->save();
        foreach ($adission->services as $service) {
            $service->status = 3;
            $service->save();
        }
        return response()->json([
            'status' => "success",
            'message' => "Adisyon iptal edildi"
        ]);
    }
}
