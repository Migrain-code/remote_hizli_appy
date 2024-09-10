<?php

namespace App\Http\Resources\Business;

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
            "category"=> $this->categorys->getName(),
            "category_id" => $this->categorys->id,
            "sub_category"=> $this->subCategory->getName(),
            "sub_category_id"=> $this->subCategory->id,
            "price"=> $this->price,
            "time" => $this->time,
            "prefered" => $this->is_featured == 1 ? 0 : 1,
        ];
    }
}
