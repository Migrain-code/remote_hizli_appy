<?php

namespace App\Http\Resources\Dept;

use App\Http\Resources\Customer\AbsentListResoruce;
use Illuminate\Http\Resources\Json\JsonResource;

class DeptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected function calculateStatus()
    {
        $daysDifference = now()->diffInDays($this->payment_date);

        if ($this->status == 1){
            return "Ödendi";
        }else {
            if ($this->payment_date < now()) {
                return "{$daysDifference} Gün Geçti";
            }  else {
                return "{$daysDifference} Gün Kaldı";
            }
        }

    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => AbsentListResoruce::make($this->customer),
            'paymentDate' => $this->payment_date,
            'paymentDateFormatted' => $this->payment_date->format('d.m.Y'),
            'price' => $this->price,
            'status' => $this->calculateStatus(),
            'note' => $this->note,
        ];
    }
}
