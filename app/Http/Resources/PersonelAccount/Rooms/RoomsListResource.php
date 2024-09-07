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
            'id' => $this->room ? $this->room->id : 0, // Safely check if the room exists
            'name' => $this->room ? $this->room->name : 'Salon', // Fallback name if no room is found
        ];
    }
}
