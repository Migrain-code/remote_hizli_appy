<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomWorkTime\CustomWorkTimeAddRequest;
use App\Http\Resources\CustomWorkTime\WorkTimeDetailResource;
use App\Http\Resources\CustomWorkTime\WorkTimeListResource;
use App\Http\Resources\Service\PersonelListResource;
use App\Models\PersonelWorkTime;
use Illuminate\Http\Request;

class CustomWorkTimeController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->business = $this->user->business;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workTimes = $this->business->customWorkTimes;
        return response()->json(WorkTimeListResource::collection($workTimes));
    }

    public function create()
    {
        $personels = $this->business->personels;
        return response()->json(PersonelListResource::collection($personels));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomWorkTimeAddRequest $request)
    {
        foreach ($request->personels as $personelId){
            $personelCustomWorkTime = new PersonelWorkTime();
            $personelCustomWorkTime->personel_id = $personelId;
            $personelCustomWorkTime->business_id = $this->business->id;
            $personelCustomWorkTime->start_date = $request->start_date;
            $personelCustomWorkTime->end_date = $request->end_date;
            $personelCustomWorkTime->start_time = $request->start_time;
            $personelCustomWorkTime->end_time = $request->end_time;
            $personelCustomWorkTime->save();
        }

        return response()->json([
            "status" => "success",
            "message" => "Personellere özel çalışma saatleri eklendi"
        ], 200);
    }

    public function destroy(PersonelWorkTime $customWorkTime)
    {
        $customWorkTime->delete();
        return response()->json([
            "status" => "success",
            "message" => "Özel çalışma saati silindi"
        ], 200);
    }
}
