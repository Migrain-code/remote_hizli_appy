<?php

namespace App\Http\Resources\Appointment;

use App\Http\Resources\Customer\CustomerDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'customer' => CustomerDetailResource::make($this->customer),
            'service' => $this->services->isNotEmpty() && optional($this->services->first()->service)->subCategory
                ? $this->services->first()->service->subCategory->name . ($this->services->count() > 1 ? " +".($this->services->count()-1) : "")
                : "Silinmiş",
            'date' => $this->start_time ? $this->start_time->format('d.m.y H:i') : $this->id,
            'status' => $this->status("text"),
            'statusColor' => $this->status("color"),
            'total' => $this->total, //formatPrice($this->totalServiceAndProduct()), // toplam
            'collectedTotal' => $this->total,//formatPrice($this->calculateCollectedTotal()) // kalan
        ];

    }

}
