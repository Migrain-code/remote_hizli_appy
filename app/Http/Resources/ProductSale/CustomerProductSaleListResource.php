<?php

namespace App\Http\Resources\ProductSale;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProductSaleListResource extends JsonResource
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
           'businessName' => $this->business->name,
           'customerName' => $this->customer->name,
           'personelName' => $this->personel->name,
           'productName' => $this->product->name,
           'piece' => $this->piece,
           'total' => $this->total,
           'seller_date' => $this->created_at->format('d.m.Y H:i')
        ];
    }
}
