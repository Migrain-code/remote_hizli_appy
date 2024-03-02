<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\AppointmentServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CashPointListResoruce extends JsonResource
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
            'created_at' => $this->addition_date->format('d.m.Y H:i:s') //tanımlanma tarihi
        ];
    }
}
