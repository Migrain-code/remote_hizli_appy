<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessPackageResource extends JsonResource
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
            'id'=> $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'type' => $this->type,
            'typeName' => $this->type == 0 ? "Aylık" : "Yıllık",
            'proparties' => BusinessPackagePropartieResource::collection( $this->proparties),
        ];
    }
}
