<?php

namespace App\Http\Resources\Cost;

use App\Http\Resources\BusinessCategoryResource;
use App\Http\Resources\BusinessPackageResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Resources\Json\JsonResource;

class CostCategoryListResource extends JsonResource
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
           'name' => $this->name,
        ];
    }
}
