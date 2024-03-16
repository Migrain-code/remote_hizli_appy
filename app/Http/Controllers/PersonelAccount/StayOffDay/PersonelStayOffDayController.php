<?php

namespace App\Http\Controllers\PersonelAccount\StayOffDay;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonelAccount\StayOffDayAddRequest;
use App\Http\Resources\PersonelAccount\StayOffDayListResource;
use App\Models\PersonelStayOffDay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Personel Hesabı İzinler
 *
 */
class PersonelStayOffDayController extends Controller
{
    private $personel;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->personel = auth()->user();
            return $next($request);
        });
    }
    /**
     * İzin Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $business = $this->personel->business;

        $stayOffDays = $business->personelStayOffDays()
            ->whereDate('start_time', '<=', $request->input('date'))
            ->whereDate('end_time', '>=', $request->input('date'))
            ->get();
        return response()->json(StayOffDayListResource::collection($stayOffDays));
    }

    /**
     * İzin Ekleme
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StayOffDayAddRequest $request)
    {
        $business = $this->personel->business;

        $existPer = $business->personelStayOffDays()
            ->where('personel_id', $this->personel->id)
            ->where(function($query) use ($request) {
                $startDate = Carbon::parse($request->start_time)->toDateString();
                $endDate = Carbon::parse($request->end_time)->toDateString();

                $query->whereDate('start_time', '<=', $startDate)
                    ->whereDate('end_time', '>=', $endDate);
            })
            ->first();

        if ($existPer){
            return response()->json([
                'status' => "error",
                'message' => "Seçtiğiniz Tarihlerde İzin Eklediniz.",
            ]);
        }

        $personelStayOffDay = new PersonelStayOffDay();
        $personelStayOffDay->business_id = $business->id;
        $personelStayOffDay->personel_id = $this->personel->id;
        $personelStayOffDay->start_time = $request->start_time;
        $personelStayOffDay->end_time = $request->end_time;
        $personelStayOffDay->save();

        return response()->json([
            'status' => "success",
            'message' => "İzin Eklendi",
        ]);
    }

    /**
     * İzin Silme
     *
     * @param \App\Models\PersonelStayOffDay $stayOffDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonelStayOffDay $stayOffDay)
    {
        if ($stayOffDay->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "İzin Silindi",
            ]);
        }
    }
}
