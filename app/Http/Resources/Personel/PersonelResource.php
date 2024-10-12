<?php

namespace App\Http\Resources\Personel;

use App\Http\Resources\PersonelAccount\Rooms\RoomsListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonelResource extends JsonResource
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
          'image' => image($this->image),
          'email' => $this->email,
          'phone' => $this->phone,
          'approve_type' => $this->accepted_type,
          'start_time' => $this->start_time,
          'end_time' => $this->end_time,
          'food_start' => $this->food_start,
          'food_end' => $this->food_end,
          'gender' => $this->type->id ?? 1,
          'rate' => $this->rate,
          'productRate' => $this->product_rate,
          'appointment_range' => $this->range,
          'description' => $this->description,
          'services' => PersonelServiceResource::collection($this->services),
          'rest_day' => PersonelRestDayResource::collection($this->restDays),
          'rooms' => RoomsListResource::collection($this->rooms),
          'appointmentRange' => $this->appointmentRange,
          'safe' => $this->safe,
          'user_type' => 1,
        ];
    }
}
