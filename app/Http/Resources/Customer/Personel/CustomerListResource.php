<?php

namespace App\Http\Resources\Customer\Personel;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerListResource extends JsonResource
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
           'id' => $this->customer?->id,
           'name' => $this->customer?->name . " - ".maskPhone($this->customer?->phone),
           'phone' => $this->customer?->phone,
           'masked_phone' => maskPhone($this->customer?->phone)
        ];
    }
}