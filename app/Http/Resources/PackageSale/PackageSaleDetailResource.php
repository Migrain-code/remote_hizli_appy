<?php

namespace App\Http\Resources\PackageSale;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageSaleDetailResource extends JsonResource
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
           'customerId' => $this->customer->id,
           'sellerDate' => $this->seller_date->format('d.m.Y H:i'),
           'serviceId' => $this->service->id,
           'personelId' => $this->personel->id,
           'packageType' => $this->packageType("id"),
           'amount' => $this->amount,
           'total' => $this->total,
        ];
    }
}
