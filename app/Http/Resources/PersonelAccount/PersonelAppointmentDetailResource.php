<?php

namespace App\Http\Resources\PersonelAccount;

use App\Http\Resources\Appointment\AppointmentServiceResource;
use App\Http\Resources\Customer\CustomerDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonelAppointmentDetailResource extends JsonResource
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
            'name' => $this->customer->name,
            'date' => $this->start_time->format('d.m.Y H:i'),
            'status' => $this->status("text"),
            'statusCode' => $this->status,
            'comment_status' => $this->comment_status,
            'note' => $this->note,
            'isCampaign' => isset($this->campaign_id),
            'total' => $this->total,
            'campaignDiscount' => number_format(($this->total * $this->discount) / 100, 2),
            'cashPoint' =>  $this->point,
            'collectedTotal' => ceil($this->total - ((($this->total * $this->discount) / 100) + $this->point)),
            'services' => AppointmentServiceResource::collection($this->services->where('personel_id', auth('personel')->id())),
        ];
    }
}
