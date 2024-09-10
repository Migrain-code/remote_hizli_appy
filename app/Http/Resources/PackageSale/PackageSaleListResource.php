<?php

namespace App\Http\Resources\PackageSale;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageSaleListResource extends JsonResource
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
            'customerName' => isset($this->customer) ? $this->customer->name : 'Unknown Customer',
            'sellerDate' => $this->seller_date ? $this->seller_date->format('d.m.Y H:i') : 'Unknown Date',
            'serviceName' => isset($this->service) ? $this->service?->subCategory?->getName() : 'Unknown Service',
            'personelName' => isset($this->personel) ? $this->personel->name : 'Unknown Personel',
            'packageType' => $this->packageType("name") ?? 'Unknown Package',
            'amount' => $this->amount,
            'remainingAmount' => $this->amount - $this->usages->sum('amount'),
            'total' => $this->total . "₺",
            'payedTotal' => $this->payeds->sum('price'),
            'remainingTotal' => $this->total - $this->payeds->sum('price'),
        ];
    }

}
