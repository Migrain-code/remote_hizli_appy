<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessServiceResource extends JsonResource
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
            "id"=> $this->id,
            "type"=> $this->gender->name,
            "type_id"=> $this->gender->id,
            "category"=> $this->categorys->name,
            "category_id" => $this->categorys->id,
            "sub_category"=> $this->subCategory->name,
            "sub_category_id"=> $this->subCategory->id,
            "price"=> $this->price,
            "time" => $this->time,
        ];
    }
}
