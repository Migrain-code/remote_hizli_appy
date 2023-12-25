<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessCustomerNoteAddRequest;
use App\Http\Requests\BusinessCustomerNoteUpdateRequest;
use App\Http\Resources\BusinessCustomerNoteResource;
use App\Models\BusinessCustomerNote;
use App\Models\Customer;
use Illuminate\Http\Request;

/**
 * @group CustomerNote
 *
 */
class BusinessCustomerNoteController extends Controller
{
    /**
     * Müşteriye Not Ekleme
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessCustomerNoteAddRequest $request)
    {
        $customer = Customer::find($request->input('customer_id'));
        if ($customer) {
            $user = $request->user();
            $business = $user->business;
            $bCustomer = $business->customers()->where('customer_id', $customer->id)->first();

            $businessCustomerNote = new BusinessCustomerNote();
            $businessCustomerNote->title = $request->input('title');
            $businessCustomerNote->note = $request->input('note');
            $businessCustomerNote->business_customer_id = $bCustomer->id;

            if ($businessCustomerNote->save()){
                return response()->json([
                    'status' => "success",
                    'message' => "Not Oluşturuldu",
                ]);
            }
        } else {
            return response()->json([
                'status' => "error",
                'message' => "Hata! Müşteri Bulunamadı."
            ]);
        }

    }

    /**
     * Müşteri Not Detayı
     *
     * @param BusinessCustomerNote $customerNote
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessCustomerNote $customerNote)
    {
        return response()->json(BusinessCustomerNoteResource::make($customerNote));
    }

    /**
     * Müşteri Not Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param BusinessCustomerNote $customerNote
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessCustomerNoteUpdateRequest $request, BusinessCustomerNote $customerNote)
    {
        $customerNote->title = $request->input('title');
        $customerNote->note = $request->input('note');

        if ($customerNote->save()){
            return response()->json([
                'status' => "success",
                'message' => "Not Güncellendi",
            ]);
        }
    }

    /**
     * Müşteri Not Sil
     *
     * @param BusinessCustomerNote $customerNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessCustomerNote $customerNote)
    {
        if ($customerNote->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Not Silindi."
            ]);
        }
    }
}
