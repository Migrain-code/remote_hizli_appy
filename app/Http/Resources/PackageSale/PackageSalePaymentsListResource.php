<?php

namespace App\Http\Resources\PackageSale;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageSalePaymentsListResource extends JsonResource
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
           'price' => $this->price,
           'amount' => $this->amount,
           'created_at' => $this->created_at->format('d.m.Y H:i:s')
        ];
    }
}
