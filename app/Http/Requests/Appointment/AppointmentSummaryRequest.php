<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppointmentSummaryRequest extends FormRequest
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
            'customer_id' => "required",
            'appointment_date' => 'required|date',
            'times' => "required",
            'services' => "required",
            'discountTotal' => "required",
        ];
    }

    public function attributes()
    {

        return [
            'customer_id' => "Müşteri",
            'appointment_date' => 'Randevu Tarihi',
            'times' => "Saatler",
            'services' => "Hizmetler",
            'total' => "Toplam Ücret",
            'discountTotal' => "İndirim Tutarı",
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
