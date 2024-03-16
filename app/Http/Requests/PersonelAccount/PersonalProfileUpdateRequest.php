<?php

namespace App\Http\Requests\PersonelAccount;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonalProfileUpdateRequest extends FormRequest
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
            'email' => 'required',
            'phone' => 'required',
            'approveType' => 'required',
            'restDay' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'foodStart' => 'required',
            'foodEnd' => 'required',
            //'gender' => 'required',
            //'rate' => 'required',
            'appointmentRange' => 'required',
            'description' => 'required',
            //'services' => 'required',
            'logo' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Personel Adı',
            'email' => 'E-posta Adresi',
            'phone' => 'Telefon Numarası',
            'approveType' => 'Otomatik Onay Durumu',
            'restDay' => 'Tatil Günü',
            'startTime' => 'Başlangıç Saati',
            'endTime' => 'Bitiş Saati',
            'foodStart' => 'Yemek Başlangıç Saati',
            'foodEnd' => 'Yemek Bitiş Saati',
            //'gender' => 'Hizmet Verdiği Cinsiyet',
            //'rate' => 'Hizmet Payı',
            'appointmentRange' => 'Randevu Aralığı',
            'description' => 'Açıklama',
            //'services' => 'Hizmetler',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' =>  $validator->errors()->all(),
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
