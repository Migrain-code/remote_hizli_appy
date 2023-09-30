<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\BusinnessType;
use App\Models\BussinessPackage;
use App\Models\DayList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SetupController extends Controller
{
    public function step1()
    {
        $business_categories= BusinessCategory::all();
        return view('business.setup.step-1', compact('business_categories'));
    }

    public function step1Form(Request $request)
    {
        $request->validate([
            'category'=>"required",
            'name' => "required"
        ], [], [
            'category'=>"İşletme Kategorisi",
            'name' => "İşletme Adı"
        ]);
        $business=auth('official')->user()->business;
        $business->category_id=$request->input('category');
        if ( $business->save()){
            return to_route('business.setup.step2');

        }
    }
    public function step2()
    {
        $business_types= BusinnessType::all();
        $dayList=DayList::orderBy('id', 'asc')->get();
        $business=auth('official')->user()->business;

        return view('business.setup.step-2', compact('business_types', 'dayList', 'business'));
    }
    public function step2Form(Request $request)
    {
        //$request->dd();
        $request->validate([
            'name'=>'required',
            'business_type'=>'required',
            'phone'=>'required',
            'city'=>'required',
            'district'=>'required',
            'offDay'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
        ],[],[
            'name'=>'İşletme Adınız',
            'business_type'=>'İşletme Tipi',
            'phone'=>'İşletme Telefonu',
            'city'=>'Şehir',
            'district'=>'İlçe',
            'offDay'=>'Kapalı olduğu gün',
            'start_time'=>'Açılış Saati',
            'end_time'=>'Kapanış Saati',
        ]);
        $business=auth('business')->user();

        $business->name=$request->input('name');
        $business->type_id=$request->input('business_type');
        $business->phone=$request->input('phone');
        $business->city=$request->input('city');
        $business->district=$request->input('district');
        $business->off_day=$request->input('offDay');
        $business->about=$request->input('business_about');
        $business->start_time=$request->input('start_time');
        $business->end_time=$request->input('end_time');
        $business->save();
        return to_route('business.setup.step3');
    }

    public function step3()
    {

        $business=auth('business')->user();
        return view('business.setup.step-3', compact('business'));
    }
    public function step3Form(Request $request)
    {
        //$request->dd();
        $request->validate([
            'owner'=>'required',
            'email'=>'required',
            'owner_email'=>'required',
            'password'=>'required|confirmed',

        ],[],[
            'owner'=>'İşletme Sahibi',
            'email'=>'Telefon Numarası',
            'owner_email'=>'İşletme Sahibi Mail Adresi',
            'password'=>'Şifre',
        ]);
        $business=auth('business')->user();
        $business->owner=$request->input('owner');
        $business->email=$request->input('email');
        $business->owner_email=$request->input('owner_email');
        $business->address=$request->input('address');
        $business->password=Hash::make($request->input('password'));
        $business->save();
        return to_route('business.setup.step4');
    }

    public function step4()
    {
        $monthlyPackages=BussinessPackage::where('type', 0)->get();
        $yearlyPackages=BussinessPackage::where('type', 1)->get();
        return view('business.setup.step-4', compact('monthlyPackages', 'yearlyPackages'));
    }
    public function step4Form(Request $request)
    {
        //$request->dd();
        $request->validate([
            'package_id'=>'required',
        ],[],[
            'package_id'=>'Paket Seçim İşlemi',
        ]);
        $business=auth('business')->user();
        $business->package_id=$request->input('package_id');
        $business->save();
        return to_route('business.setup.step5');
    }
    public function step5()
    {
        return view('business.setup.step-5');
    }
}
