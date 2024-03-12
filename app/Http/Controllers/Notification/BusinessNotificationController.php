<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\BusinessNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BusinessNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'title'=>"required",
            'message'=>"required",
        ]);
        $businessNotification=new BusinessNotification();
        $businessNotification->business_id=Auth::guard('business')->id();
        $businessNotification->personel_id=$request->input('personel_id');
        $businessNotification->title=$request->input('title');
        $businessNotification->message=$request->input('message');
        $businessNotification->link=$request->input('link');
        if ($businessNotification->save()){
            return back()->with('response', [
                'status'=>"success",
                'title'=>"Başarılı",
                'message'=>"Bildirim Personele İletildi"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param BusinessNotification $businessNotification
     * @return Response
     */
    public function show(BusinessNotification $businessNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BusinessNotification $businessNotification
     * @return Response
     */
    public function edit(BusinessNotification $businessNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BusinessNotification $businessNotification
     * @return Response
     */
    public function update(Request $request, BusinessNotification $businessNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BusinessNotification $businessNotification
     * @return Response
     */
    public function destroy(BusinessNotification $businessNotification)
    {
        //
    }
}
