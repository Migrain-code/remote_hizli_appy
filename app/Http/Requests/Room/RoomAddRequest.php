<?php

namespace App\Http\Requests\Room;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoomAddRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:7', // color code is a HEX code
            'price' => 'required|integer|between:1,100',
            'status' => 'nullable'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Oda Adı',
            'color_code' => 'Renk Kodu',
            'price' => 'Yüzdelik Fiyat Artışı',
            'status' => 'Durum'
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
