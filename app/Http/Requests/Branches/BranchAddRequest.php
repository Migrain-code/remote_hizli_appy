<?php

namespace App\Http\Requests\Branches;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BranchAddRequest extends FormRequest
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
            'branchName' => 'required',
            'officialId' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'İşletme Adı',
            'branchName' => 'Şube Adı',
            'officialId' => 'Yetkili Kimliği',
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
