<?php

namespace App\Http\Requests\PersonelAccount\SpeedAppointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SpeedAppointmentCreateRequest extends FormRequest
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
            'appointment_date' => 'required|date',
            'appointment_type' => "required",
            'customer_id' => 'required',
            'room_id' => 'nullable',
            'service_id' => 'required',
            'start_time' => "required",
            'end_time' => "required",
        ];
    }

    public function attributes()
    {
        return [
            'appointment_date' => 'Randevu Tarihi',
            'appointment_type' => "Randevu Türü closeClock veya appointmentCreate olmalıdır. Bu randevu",
            'customer_id' => 'Müşteri Seçimi',
            'room_id' => 'Oda Seçimi',
            'service_id' => 'Hizmet Seçimi',
            'start_time' => "Başlangıç Saati",
            'end_time' => "Bitiş Saati",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
