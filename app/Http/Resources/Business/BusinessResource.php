<?php

namespace App\Http\Resources\Business;

use App\Http\Resources\Location\CityResource;
use App\Http\Resources\Location\DistrictResource;
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
           'shortName' => $this->name,//(strlen($this->name) > 15) ? substr($this->name, 0, 15) : $this->name,
           'branchName' => $this->branch_name,
           'email' => $this->business_email,
           'year' => $this->year,
           'personalCount' => $this->personal_count,
           'commission' => $this->commission,
           'logo' => image($this->logo),
           'phone' => $this->phone,
           'wallpaper' => image($this->wallpaper),
           'city' => new CityResource($this->cities),
           'district' => new DistrictResource($this->districts),
           'category' => new BusinessCategoryResource($this->category),
           'start_time' => $this->start_time,
           'end_time' => $this->end_time,
           'is_main' => $this->is_main == 1 ? "Ana İşletme" : "Alt İşletme",
           'packet' => new BusinessPackageResource($this->package),
           'packet_end_date' => $this->packet_end_date,
           'packet_start_date' => $this->packet_start_date,
           'appointment_range' => $this->range,
           'type' => $this->type,
           'about' => $this->about,
           'embed' => $this->embed,
           'address' => $this->address,
           'off_day' => $this->offDay,
           'latitude' => $this->lat,
           'longitude' => $this->longitude,
           'link' => "asd",
           //'link' => "https://hizlirandevu.com.tr/salon/".$this->slug ,
           'setup' => $this->setup_status,
           'setup2' => $this->services->count() > 0 && $this->personels->count() > 0 ? 1 : 0,
        ];
    }
}
