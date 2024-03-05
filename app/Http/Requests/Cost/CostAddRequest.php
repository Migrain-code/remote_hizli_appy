<?php

namespace App\Http\Requests\Cost;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CostAddRequest extends FormRequest
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
            'costCategoryId' => 'required',
            'personelId' => 'required',
            'paymentTypeId' => 'required',
            'price' => 'required',
            'operationDate' => 'required|date',
            'description' => 'nullable',
            'note' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'costCategoryId' => 'Masraf Kategorisi',
            'personelId' => 'Personel',
            'paymentTypeId' => 'Ödeme Türü',
            'price' => 'Tutar',
            'operationDate' => 'Tarih',
            'description' => 'Açıklama',
            'note' => 'Not',
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
