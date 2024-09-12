<?php

namespace App\Http\Resources\Cost;

use App\Http\Resources\Personel\PersonelListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CostListResource extends JsonResource
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
           'costCategory' => new CostCategoryListResource($this->category),
           'personel' => new PersonelListResource($this->personel),
           'paymentType' => $this->type(),
           'price' => $this->price,
           'operation_date' => $this->operation_date->format('d.m.y'),
           'description' => $this->description,
        ];
    }
}
