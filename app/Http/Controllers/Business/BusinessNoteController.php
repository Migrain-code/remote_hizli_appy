<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\BusinessNote;
use Illuminate\Http\Request;

class BusinessNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => "required"
        ], [], [
            'name' => "Kullanıcı Adı"
        ]);
        $businessNote=new BusinessNote();
        $businessNote->title=$request->input('title');
        $businessNote->content=$request->input('content');
        $businessNote->business_id=authUser()->id;
        if ($businessNote->save()){
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessNote  $businessNote
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessNote $businessNote)
    {
        return $businessNote;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessNote  $businessNote
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessNote $businessNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessNote  $businessNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessNote $businessNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessNote  $businessNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessNote $businessNote)
    {
        if ($businessNote->delete()){
            return response()->json([
               'status'=>'success',
               'message'=>"Silindi"
            ]);
        }
    }
}
