<?php

namespace App\Http\Resources\Rooms;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomsDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $statusCodes = [
            0 => [
                "id" => 0,
                'text' => 'Pasif',
                "color" => "#fff04f"
            ],
            1 => [
                "id" => 1,
                'text' => 'Aktif',
                "color" => "#6aab73"
            ],
        ];
        return [
           'id' => $this->id,
           'name' => $this->name,
           'colorCode' => $this->color,
           'price' => "% ".$this->price,
           'status' => $this->status == 1,
           'statusCode' => $this->status,
           'statusList' => $statusCodes
        ];
    }
}
