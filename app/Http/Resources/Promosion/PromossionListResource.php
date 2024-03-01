<?php

namespace App\Http\Resources\Promosion;

use Illuminate\Http\Resources\Json\JsonResource;

class PromossionListResource extends JsonResource
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
            'cash' => $this->cash,
            'credit_cart' => $this->credit_cart,
            'eft' => $this->eft,
            'use_limit' => $this->use_limit,
            'birthday_discount' => $this->birthday_discount,
        ];
    }
}
