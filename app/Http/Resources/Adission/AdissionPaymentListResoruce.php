<?php

namespace App\Http\Resources\Adission;

use App\Http\Resources\AppointmentServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdissionPaymentListResoruce extends JsonResource
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
            'paymentTypeId' => $this->payment_type_id,
            'paymentName' => $this->type("name"),
            'created_at' => $this->created_at->format('d.m.Y H:i:s')
        ];
    }
}
