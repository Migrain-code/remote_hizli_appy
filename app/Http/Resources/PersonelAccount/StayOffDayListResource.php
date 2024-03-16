<?php

namespace App\Http\Resources\PersonelAccount;

use Illuminate\Http\Resources\Json\JsonResource;

class StayOffDayListResource extends JsonResource
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
           'personel' => $this->personel->name,
           'start_time' => $this->start_time->format('d.m.Y H:i'),
           'end_time' => $this->end_time->format('d.m.Y H:i'),
        ];
    }
}
