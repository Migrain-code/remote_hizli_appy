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
            'payment_type_id' => $this->payment_type,
            'payment_type' => $this->type("name"),
            'form_name' => $this->type("form_name"),
            'rate' => $this->rate,
        ];
    }
}
