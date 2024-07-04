<?php

namespace App\Http\Resources\PersonelAccount\SpeedAppointment;

use App\Http\Resources\Business\BusinessResource;
use App\Http\Resources\Personel\PersonelRestDayResource;
use App\Http\Resources\Personel\PersonelServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonelAppointmentServiceResource extends JsonResource
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
            "id"=> $this->service->id,
            "name"=> $this->service->subCategory->getName(). " - ". $this->service->gender->name,
        ];
    }
}
