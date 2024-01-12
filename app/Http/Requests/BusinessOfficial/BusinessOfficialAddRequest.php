<?php

namespace App\Http\Requests\BusinessOfficial;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BusinessOfficialAddRequest extends FormRequest
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
            'phone' => 'required|min:11|max:11',
            'email' => 'required|email',
            'password' => 'required',
            'branch_id' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Yetkili Adı',
            'phone' => 'Telefon Numarası',
            'email' => 'E-posta',
            'password' => 'Şifre',
            'branch_id' => 'Şube Seçimi'
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
