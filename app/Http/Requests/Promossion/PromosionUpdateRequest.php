<?php

namespace App\Http\Requests\Promossion;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PromosionUpdateRequest extends FormRequest
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
            'cash' => 'required|between:0,100',
            'creditCard' => 'required|between:0,100',
            'eft' => 'required|between:0,100',
            'limit' => 'required|between:0,100',
            'birthday'=> 'required|between:0,100',
        ];
    }

    public function attributes()
    {
        return [
            'cash' => 'Nakit Ödeme Promosyonu',
            'credit_cart' => 'Kredi Kartı Ödeme Promosyonu',
            'eft' => 'EFT/Havale Promosyonu',
            'use_limit' => 'Parapuan Kullanım Limiti',
            'birthday_discount' => 'Doğum Günü İndirimi Promosyonu',
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
