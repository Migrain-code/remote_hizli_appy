<?php

namespace App\Http\Resources\Personel;

use Illuminate\Http\Resources\Json\JsonResource;

class MaasListResource extends JsonResource
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
           'operation_date' => $this->operation_date->format('d.m.Y'),
           'paymentType' => $this->type(),
           'price' => $this->price,
        ];
    }
}
