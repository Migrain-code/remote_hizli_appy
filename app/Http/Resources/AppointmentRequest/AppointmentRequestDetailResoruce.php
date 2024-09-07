<?php

namespace App\Http\Resources\AppointmentRequest;

use App\Http\Resources\Appointment\AppointmentServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentRequestDetailResoruce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $phone = clearPhone($this->phone);
        if ($this->contact_type == 2){
            $phone = maskPhone($phone);
        }
        return [
            'id' => $this->id,
            'customerName' => $this->user_name,
            'serviceName' => $this->service_name,
            'goalTimeType' => $this->goal_time_type == 1 ? "Belirli bir tarihte": ($this->goal_time_type == 2 ? "Belirli bir süre içerisinde" : "Tarih belli değil"),
            'call_date' => isset($this->call_date) ? $this->call_date->format('d.m.Y H:i') : "Belirlenmemiş",
            'status' => $this->status("text"),
            'phone' => $phone,
            'email' => $this->email,
            'note' => $this->note,
            'addedServices' => $this->added_services,
            'contactType' => $this->contact_type == 1 ? "Aranabilir" : "Aranamaz",
            'contactTypeCode' => $this->contact_type,
            'questions' => $this->editQuestions($this->questions)
        ];
    }

    public function editQuestions($questions)
    {
        $formattedQuestions = [];

        foreach ($questions as $question => $answer) {
            $formattedQuestions[] = [
                'question' => $question,
                'answer' => $answer
            ];
        }

        return $formattedQuestions;
    }
}
