<?php

namespace App\Http\Resources\PackageSale;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerPackageSaleListResource extends JsonResource
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
           'customerName' => $this->customer->name,
           'sellerDate' => $this->seller_date->format('d.m.Y H:i'),
           'serviceName' => $this->service?->subCategory?->getName(),
           'personelName' => $this->personel->name,
           'packageType' => $this->packageType("name"),
           'amount' => $this->amount,
           'remainingAmount' => $this->amount - $this->usages->sum('amount'),
           'total' => $this->total. "₺",
           'payedTotal' => $this->payeds->sum('price'),
           'remainingTotal' =>  $this->total - $this->payeds->sum('price')
        ];
    }
}
