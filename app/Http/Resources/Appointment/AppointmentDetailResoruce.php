<?php

namespace App\Http\Resources\Appointment;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentDetailResoruce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total = calculateTotal($this->services) + $this->sales->sum("total");
        return [
            'id' => $this->id,
            'name' => $this->customer->name,
            'phone' => $this->customer->phone,
            'date' => $this->start_time->format('d.m.Y H:i'),
            'status' => $this->status("text"),
            'statusCode' => $this->status,
            'comment_status' => $this->comment_status,
            'note' => $this->note,
            'isCampaign' => isset($this->campaign_id),
            'total' => $this->total,
            'campaignDiscount' => number_format(($total * $this->discount) / 100, 2),
            'cashPoint' =>  $this->point,
            'collectedTotal' => $total - ((($total * $this->discount) / 100) + $this->point),
            'services' => AppointmentServiceResource::collection($this->services),
        ];
    }
}
