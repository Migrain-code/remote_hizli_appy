<?php

namespace App\Http\Resources\Dept;

use App\Http\Resources\Customer\AbsentListResoruce;
use App\Http\Resources\CustomerListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DeptResource extends JsonResource
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
            'paymentDate' => $this->payment_date,
            'paymentDateFormatted' => $this->payment_date->format('d.m.Y'),
            'price' => $this->price,
            'status' => $this->payment_date < now() ? now()->diffInDays($this->payment_date) . " Gün Geçti" : ($this->status == 1 ? "Ödendi" : now()->diffInDays($this->payment_date) . " Gün Kaldı"),
            'note' => $this->note,
        ];
    }
}