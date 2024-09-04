<?php

namespace App\Http\Resources\AppointmentRequest;

use App\Http\Resources\Appointment\AppointmentServiceResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentRequestListResoruce extends JsonResource
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
            'created_at' => $this->created_at->format('d.m.Y H:i'),
            'status' => $this->status("text"),
            'statusCode' => $this->status,
            'phone' => $phone,
            'call_date' => $this->call_date->toIso8601String(),
            'answer' => $this->answer,
        ];
    }
}
