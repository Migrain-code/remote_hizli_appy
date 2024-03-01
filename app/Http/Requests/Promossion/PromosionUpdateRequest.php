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
            'cash' => 'required',
            'credit_cart' => 'required',
            'eft' => 'required',
            'use_limit' => 'required',
            'birthday_discount'=> 'required',
        ];
    }

    public function attributes()
    {
        return [
            'cash' => 'Nakit Ödeme Promosyonu',
            'credit_cart' => 'E-posta',
            'eft' => 'Şifre',
            'use_limit' => 'Cinsiyet',
            'birthday_discount' => 'Doğum Günü',
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
