<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerAddRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required',
            //'email' => 'required',
            'password' => 'required',
            //'gender' => 'required',
            //'birthday'=> 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Müşteri Adı',
            'phone' => 'Telefon Numarası',
            //'email' => 'E-posta',
            'password' => 'Şifre',
            //'gender' => 'Cinsiyet',
            //'birthday' => 'Doğum Günü',
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
