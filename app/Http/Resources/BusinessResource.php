<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
           'logo' => image($this->logo),
           'wallpaper' => image($this->wallpaper),
           'city' => new CityResource($this->cities),
           'district' => new DistrictResource($this->districts),
           'start_time' => $this->start_time,
           'end_time' => $this->end_time,
           'is_main' => $this->is_main == 1 ? "Ana İşletme" : "Alt İşletme",
            
        ];
    }
}
