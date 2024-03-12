<?php

namespace App\Http\Resources\Receivable;

use App\Http\Resources\Customer\AbsentListResoruce;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceivableDetailResource extends JsonResource
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
            'customer' => AbsentListResoruce::make($this->customer),
            'appointmentId' => $this->appointment_id,
            'paymentDate' => $this->payment_date,
            'paymentDateFormatted' => $this->payment_date->format('d.m.Y'),
            'price' => $this->price,
            'status' => $this->payment_date < now() ? now()->diffInDays($this->payment_date) . " Gün Geçti" : ($this->status == 1 ? "Ödendi" : now()->diffInDays($this->payment_date) . " Gün Kaldı"),
            'note' => $this->note,
        ];
    }
}
