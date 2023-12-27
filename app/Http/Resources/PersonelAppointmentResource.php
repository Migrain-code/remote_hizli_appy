<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PersonelAppointmentResource extends JsonResource
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
          'date' => Carbon::parse($this->start_time)->translatedFormat('d F Y H:i'),
          'customer'=>$this->appointment->customer->name,
          'service'=>$this->service->subCategory->getName() == "",
          'status' => $this->status("text"),
          'total' => $this->service->price. " ₺",
        ];
    }
}
