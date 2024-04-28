<?php

namespace App\Http\Resources\PersonelAccount;

use App\Http\Resources\Business\BusinessResource;
use App\Http\Resources\Personel\PersonelRestDayResource;
use App\Http\Resources\Personel\PersonelServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
          'appointment_range' => $this->range,
          'description' => $this->description,
          'appointmentRange' => $this->appointmentRange,
          'services' => PersonelServiceResource::collection($this->services),
          'closeDay' => $this->restDays,
          'safe' => $this->safe,
          'user_type' => 1,
          'about_text' => "asd",
          'business' => BusinessResource::make($this->business),
        ];
    }
}
