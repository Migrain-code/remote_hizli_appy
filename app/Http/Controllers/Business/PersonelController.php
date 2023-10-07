<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessService;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelNotification;
use App\Models\PersonelService;
use App\Models\ServiceShare;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersonelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {

        $rates=ServiceShare::where('rate',"<>", null)->orderBy("rate")->get();
        $dayList=DayList::orderBy("id")->get();
        return view('business.personel.index', compact( 'rates', 'dayList'));
    }
    public function get(Request $request)
    {
        $perPage = 5;

        $data = PersonelNotification::where('personel_id', $request->personel_id)->skip(intval($request->last_id))->take($perPage)->get();

        return response()->json([
            'data'=>$data
        ]);
    }
    public function sendNotification(Request $request)
    {
        $request->validate([
            'title'=>"required",
            'message'=>"required",
        ]);
        $personelNotification=new PersonelNotification();
        $personelNotification->business_id=Auth::guard('business')->id();
        $personelNotification->personel_id=$request->input('personel_id');
        $personelNotification->title=$request->input('title');
        $personelNotification->message=$request->input('message');
        $personelNotification->link=$request->input('link');
        if ($personelNotification->save()){
            return back()->with('response', [
                'status'=>"success",
                'title'=>"Başarılı",
                'message'=>"Bildirim Personele İletildi"
            ]);
        }
    }
    public function gender(Request $request)
    {
        if ($request->gender == 3){
            $services=BusinessService::where('business_id', auth('business')->id())
                ->with('subCategory')
                ->with('gender')
                ->orderBy('type')
                ->get();
        }
        else{
            $services=BusinessService::where('business_id', auth('business')->id())
                ->where('type', $request->gender)
                ->with('subCategory')
                ->with('gender')
                ->orderBy('type')
                ->get();
        }
        return $services;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $personel= new Personel();
        $personel->business_id=auth('business')->id();
        $personel->name= $request->input('name');
        $personel->image="business/team.png";
        $personel->email=$request->email;
        $personel->password=Hash::make($request->password);
        $personel->phone=$request->phone;
        $personel->accept=$request->accept;
        $personel->rest_day=$request->off_day;
        $personel->start_time=$request->start_time;
        $personel->end_time=$request->end_time;
        $personel->food_start=$request->food_start_time;
        $personel->food_end=$request->food_end_time;
        $personel->gender=auth('business')->user()->type->id==3 ? $request->gender : auth('business')->user()->type->id;
        $personel->rate=$request->rate;
        $personel->range=$request->range;
        $personel->description=$request->description;
        if ($personel->save()){
            if (in_array('all', $request->services)){
                    $findBusinessService=auth('business')->user()->services;
                    foreach ($findBusinessService as $service){
                        $personelService=new PersonelService();
                        $personelService->service_id=$service->id;
                        $personelService->personel_id=$personel->id;
                        $personelService->save();
                    }
            }
            else{
                foreach ($request->services as $service){
                    $personelService=new PersonelService();
                    $personelService->service_id=$service;
                    $personelService->personel_id=$personel->id;
                    $personelService->save();
                }
            }
            return to_route('business.personel.index')->with('response', [
                'status'=>"success",
                'title'=>"Başarılı",
                'message'=>"Personel Eklendi"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Personel $personel
     * @return Response
     */
    public function show(Personel $personel)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Personel $personel
     * @return Response
     */
    public function edit(Personel $personel)
    {

        $dayList=DayList::all();
        $rates=ServiceShare::where('rate',"<>", null)->orderBy("rate")->get();
        $services = [];
        foreach ($personel->services as $service){
            $services[]=$service->service_id;
        }
        return view('business.personel.edit', compact('personel','dayList', 'rates', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Personel $personel
     * @return Response
     */
    public function update(Request $request, Personel $personel)
    {
        $personel->business_id=auth('business')->id();
        $personel->name= $request->input('name');
        $personel->image="business/team.png";
        $personel->email=$request->email;
        $personel->password=Hash::make($request->password);
        $personel->phone=$request->phone;
        $personel->accept=$request->accept;
        $personel->rest_day=$request->off_day;
        $personel->start_time=$request->start_time;
        $personel->end_time=$request->end_time;
        $personel->food_start=$request->food_start_time;
        $personel->food_end=$request->food_end_time;
        $personel->gender=auth('business')->user()->type->id==3 ? $request->gender : auth('business')->user()->type->id;
        $personel->rate=$request->rate;
        $personel->range=$request->range;
        $personel->description=$request->description;
        if ($personel->save()){
            PersonelService::where('personel_id', $personel->id)->delete();
            if (in_array('all', $request->services)){
                $findBusinessService=auth('business')->user()->services;
                foreach ($findBusinessService as $service){
                    $personelService=new PersonelService();
                    $personelService->service_id=$service->id;
                    $personelService->personel_id=$personel->id;
                    $personelService->save();
                }
            }
            else{
                foreach ($request->services as $service){
                    $personelService=new PersonelService();
                    $personelService->service_id=$service;
                    $personelService->personel_id=$personel->id;
                    $personelService->save();
                }
            }
            return to_route('business.personel.index')->with('response', [
                'status'=>"success",
                'title'=>"Başarılı",
                'message'=>"Personel Bilgileri Güncellendi"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Personel $personel
     * @return Response
     */
    public function destroy(Personel $personel)
    {

        if ($personel->delete()){
        return response()->json([
            'status'=>"success",
        ]);
    }
    }
}
