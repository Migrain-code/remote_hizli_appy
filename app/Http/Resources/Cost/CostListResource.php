<?php

namespace App\Http\Resources\Cost;

use App\Http\Resources\BusinessCategoryResource;
use App\Http\Resources\BusinessPackageResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\PersonelListResource;
use App\Models\City;
use App\Models\District;
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
           'operation_date' => $this->operation_date->format('d.m.Y')
        ];
    }
}
