<?php

namespace App\Http\Resources\ProductSale;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSaleDetailResource extends JsonResource
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
           'customerName' => $this->customer->id,
           'personelName' => $this->personel->id,
           'productName' => $this->product->id,
           'piece' => $this->piece,
           'total' => $this->total,
           'seller_date' => $this->created_at->format('d.m.Y H:i:s'),
           'payment_type' => $this->payment_type,
           'note' => $this->note,
        ];
    }
}
