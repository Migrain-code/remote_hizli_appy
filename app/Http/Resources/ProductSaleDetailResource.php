<?php

namespace App\Http\Resources;

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
           'customerName' => CustomerDetailResource::make($this->customer),
           'personelName' => PersonelListResource::collection($this->personel),
           'productName' => ProductResource::make($this->product),
           'piece' => $this->piece,
           'total' => $this->total,
           'seller_date' => $this->created_at->format('d.m.Y H:i:s'),

           'note' => $this->note,
        ];
    }
}
