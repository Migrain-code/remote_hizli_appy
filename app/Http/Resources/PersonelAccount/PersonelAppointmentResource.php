<?php

namespace App\Http\Resources\PersonelAccount;

use App\Http\Resources\Customer\CustomerDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonelAppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $services = $this->services->where('personel_id', auth('personel')->id());

        return [
            'id' => $this->id,
            'customer' => CustomerDetailResource::make($this->customer),
            'service' => $services->first()->service->subCategory->name . ($services->count() > 1 ? " +".$services->count()-1 : ""),
            'date' =>  $services->first()->start_time->format('d.m.y H:i'),
            'status' => $this->status("text"),
            'statusColor' => $this->status("color"),
            'total' =>  $this->calculateCollectedTotal(),
        ];
    }
}
