<?php

namespace App\Http\Resources\Cost;

use App\Http\Resources\Personel\PersonelListResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CostEditResource extends JsonResource
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
           'operationDate' => $this->operation_date->format('Y-m-d\TH:i:s.v\Z'),
           'description' => $this->description,
        ];
    }
}
