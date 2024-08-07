<?php

namespace App\Http\Requests\Promossion;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
            'cash' => ['required', 'numeric', 'between:0,100'],
            'creditCard' => ['required', 'numeric', 'between:0,100'],
            'eft' => ['required', 'numeric', 'between:0,100'],
            'limit' => ['required'],
            'birthday'=> ['required', 'numeric', 'between:0,100'],
        ];
    }

    public function attributes()
    {
        return [
            'cash' => 'Nakit Ödeme Promosyonu',
            'creditCard' => 'Kredi Kartı Ödeme Promosyonu',
            'eft' => 'EFT/Havale Promosyonu',
            'limit' => 'Parapuan Kullanım Limiti',
            'birthday' => 'Doğum Günü İndirimi Promosyonu',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' =>  $validator->errors()->first(),
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
