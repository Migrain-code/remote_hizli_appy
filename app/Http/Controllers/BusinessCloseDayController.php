<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusinessCloseDay\CloseDayEditResource;
use App\Http\Resources\BusinessCloseDay\CloseDayListResource;
use App\Models\BusinessCloseDate;
use Illuminate\Http\Request;

class BusinessCloseDayController extends Controller
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
    public function index()
    {
        return response()->json(CloseDayListResource::collection($this->business->closeDays));
    }
    public function store(Request $request)
    {
        $closeDate = new BusinessCloseDate();
        $closeDate->start_time = $request->input('start_time');
        $closeDate->end_time = $request->input('end_time');
        $closeDate->business_id = $this->business->id;
        if ($closeDate->save()){
            return response()->json([
                'status' => "success",
                'message' => "Kapalı Gün Eklendi"
            ]);
        }
    }

    public function show(BusinessCloseDate $closeDay)
    {
        return response()->json(CloseDayEditResource::make($closeDay));
    }

    public function update(BusinessCloseDate $closeDay, Request $request)
    {
        $closeDay->start_time = $request->input('start_time');
        $closeDay->end_time = $request->input('end_time');
        $closeDay->business_id = $this->business->id;
        if ($closeDay->save()){
            return response()->json([
                'status' => "success",
                'message' => "Kapalı Gün Güncellendi"
            ]);
        }
    }

    public function destroy(BusinessCloseDate $closeDay)
    {
        if ($closeDay->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Kapalı Gün Silindi"
            ]);
        }
    }
}
