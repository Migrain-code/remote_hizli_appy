<?php

namespace App\Http\Requests\PackageSale;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PackageSaleAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "seller_date" => "required|date",
            "customer_id" => "required",
            "service_id" => "required",
            "package_type" => "required",
            "personel_id" => "required",
            "amount" => "required",
            "total" => "required",
        ];
    }

    public function attributes()
    {
        return [
            'seller_date' => 'Satış Tarihi',
            'customer_id' => 'Müşteri',
            'service_id' => 'Hizmet',
            'package_type' => 'Paket Türü',
            'personel_id' => 'Satıcı',
            'amount' => 'Adet',
            'total' => 'Fiyat'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Eksik Alanlar Var',
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
