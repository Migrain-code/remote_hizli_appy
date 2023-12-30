<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonelStayOffDayAddRequest;
use App\Http\Resources\PersonelListResource;
use App\Http\Resources\PersonelStayOffDayListResource;
use App\Models\PersonelStayOffDay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Personel İzin
 *
 */
class PersonelStayOffDayController extends Controller
{
    /**
     * İzin Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        $stayOffDays = $business->personelStayOffDays()
            ->whereDate('start_time', '<=', $request->input('date'))
            ->whereDate('end_time', '>=', $request->input('date'))
            ->get();
        return response()->json(PersonelStayOffDayListResource::collection($stayOffDays));
    }

    /**
     * İzin Oluşturma
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        return response()->json(PersonelListResource::collection($business->personels));
    }

    /**
     * İzin Ekleme
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonelStayOffDayAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $stayOffDays = $business->personelStayOffDays()->pluck('personel_id')->toArray();

        foreach ($request->personels as $personelId) {

            $existPer = $business->personelStayOffDays()
                ->where('personel_id', $personelId)
                ->whereDate('start_time', Carbon::parse($request->start_time)->toDateString())
                ->orWhere('end_time', Carbon::parse($request->end_time)->toDateString())
                ->first();

            if ($existPer){
                return response()->json([
                    'status' => "error",
                    'message' => "Bu Tarihlerde ". $existPer->personel->name ." Personeline İzin Eklediniz. Personeli Listeden Çıkarıp Sonradan Sadece Bu Personeli Seçerek Ekleyebilirsiniz.",
                ]);
            }

            $personelStayOffDay = new PersonelStayOffDay();
            $personelStayOffDay->business_id = $business->id;
            $personelStayOffDay->personel_id = $personelId;
            $personelStayOffDay->start_time = $request->start_time;
            $personelStayOffDay->end_time = $request->end_time;
            $personelStayOffDay->save();
        }

        return response()->json([
            'status' => "success",
            'message' => "İzin Eklendi",
        ]);
    }

    /**
     * İzin Silme
     *
     * @param \App\Models\PersonelStayOffDay $personelStayOffDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonelStayOffDay $personelStayOffDay)
    {
        if ($personelStayOffDay->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "İzin Silindi",
            ]);
        }
    }
}
