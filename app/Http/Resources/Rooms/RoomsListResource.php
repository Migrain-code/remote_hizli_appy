<?php

namespace App\Http\Resources\Rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomsListResource extends JsonResource
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
           'colorCode' => $this->color,
           'price' => "% ".$this->price,
           'status' => $this->status == 1
        ];
    }
}
