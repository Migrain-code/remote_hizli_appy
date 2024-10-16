<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerAddRequest;
use App\Http\Resources\Appointment\AppointmentResource;
use App\Http\Resources\Business\BusinessCustomerNoteResource;
use App\Http\Resources\Customer\CustomerDetailResource;
use App\Http\Resources\Customer\CustomerListResource;
use App\Models\BusinessCustomer;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group Customer
 * */
class CustomerController extends Controller
{
    /**
     * Müşteri Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $customers = $business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%'])->orWhere('phone', 'like', '%' . $name . '%');
                });
            })
            ->take(150)->get();
        return response()->json(CustomerListResource::collection($customers));
    }

    /**
     * Müşteri Ekleme
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerAddRequest $request)
    {
        $user = $request->user();
        $business = $user->business;

        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->phone = clearPhone($request->input('phone'));
        $customer->email = $request->input('email');
        $customer->password = Hash::make($request->input('password'));
        $customer->gender = $request->input('gender');
        $customer->birthday = Carbon::parse($request->input('birthday'))->format('Y-m-d');

        $customer->status = 1;
        if ($customer->save()) {
            $businessCustomer = new BusinessCustomer();
            $businessCustomer->business_id = $business->id;
            $businessCustomer->customer_id = $customer->id;
            $businessCustomer->type = 1;
            $businessCustomer->save();
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Eklendi. Artık bu müşteriler için işlem yapabilirsiniz."
            ]);
        }
    }

    /**
     * Müşteri Detayı
     *
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, Request $request)
    {
        $user = $request->user();
        $business = $user->business;
        $bCustomer = $business->customers()->where('customer_id', $customer->id)->first();

        return response()->json([
            'customer' => CustomerDetailResource::make($customer),
            'notes' => BusinessCustomerNoteResource::collection($bCustomer->notes),
            'appointments' => AppointmentResource::collection($customer->appointments),
        ]);
    }

    /**
     * Müşteri Düzenleme
     *
     *
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return response()->json([
            'customer' => CustomerDetailResource::make($customer),
        ]);
    }

    /**
     * Müşteri Güncelle
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $user = $request->user();
        $business = $user->business;

        $customer->name = $request->input('name');
        $customer->phone = clearPhone($request->input('phone'));
        $customer->email = $request->input('email');
        $customer->password = Hash::make($request->input('password'));
        $customer->gender = $request->input('gender');
        $customer->status = 1;
        if ($customer->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Müşteri bilgileri güncellendi."
            ]);
        }
    }

    /**
     * Müşteri Sil
     *
     * @param  Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, Request $request)
    {
        $user = $request->user();
        $business = $user->business;

        if ($customer) {
            $business->customers()->where('customer_id', $customer->id)->delete();
            return response()->json([
                'status' => "success",
                'message' => "Müşteri, Müşteri Listenizden Silindi."
            ]);
        }
    }
}
