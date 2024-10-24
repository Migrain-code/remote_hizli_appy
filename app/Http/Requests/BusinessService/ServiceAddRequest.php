<?php

namespace App\Http\Requests\BusinessService;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceAddRequest extends FormRequest
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
            'typeId' => 'required',
            'categoryId' => 'required',
            'subCategoryId' => 'required',
            'time' => 'required',
            //'price' => 'required',
        ];
    }

    public function attributes()
    {

        return [
            'typeId' => 'Cinsiyet',
            'categoryId' => 'Kategori',
            'subCategoryId' => 'Hizmet',
            'time' => 'Süre',
            //'price' => 'Fiyat',
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
