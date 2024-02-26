<?php

namespace App\Http\Resources\Appointment;

use App\Http\Resources\AppointmentServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentPhotoResource extends JsonResource
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
            'image' => image($this->image),
        ];
    }
}
