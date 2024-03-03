<?php

namespace App\Http\Requests\Receivable;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ReceivableAddRequest extends FormRequest
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
            'paymentDate' => 'required|date',
            'price' => 'required',
            'note' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            'paymentDate' => 'Ödenecek Tarih',
            'price' => 'Tutar',
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
