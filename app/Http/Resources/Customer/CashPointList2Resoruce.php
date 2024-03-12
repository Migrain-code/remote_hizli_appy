<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class CashPointList2Resoruce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'appointmentId' => $this->appointment_id,
            'businessName' => $this->appointment->business->name,
            'created_at' => $this->addition_date->format('d.m.Y H:i:s') //tanımlanma tarihi
        ];
    }
}
