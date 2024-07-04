<?php

namespace App\Http\Resources\PersonelAccount\Rooms;

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
           'id' => $this->room_id == 0 ? 0 : $this->room->id,
           'name' =>$this->room_id == 0 ? "Salon" : $this->room->name,
        ];
    }
}
