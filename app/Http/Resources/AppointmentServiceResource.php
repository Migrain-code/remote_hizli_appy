<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentServiceResource extends JsonResource
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
          'personel' => PersonelListResource::make($this->personel),
          'serviceName' => $this->service->subCategory->name,
          'price' => $this->service->price,
          'gender' => $this->service->gender->name,
          'clock' => $this->start_time->format('H:i'),
          'start_time' => $this->start_time->format('d.m.Y H:i'),
          'end_time' => $this->end_time->format('d.m.Y H:i'),
        ];
    }
}
