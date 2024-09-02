<?php

namespace App\Http\Resources\CustomWorkTime;

use App\Http\Resources\Customer\AbsentListResoruce;
use App\Http\Resources\Personel\PersonelListResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkTimeDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dayCount' => $this->start_date->diffInDays($this->end_date),
            'start_date' => $this->start_date->format('d.m.Y'),
            'end_date' => $this->end_date->format('d.m.Y'),
            'clock_start' => $this->start_time->format('H:i'),
            'clock_end' => $this->end_time->format('H:i'),
            'status' => $this->status == 1 ? "Aktif" : "Pasif",
            "personel" => PersonelListResource::make($this->personel)
        ];
    }
}
