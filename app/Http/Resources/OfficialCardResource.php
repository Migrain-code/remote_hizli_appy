<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfficialCardResource extends JsonResource
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
           'name' => $this->name,
           'card_number' => $this->number,
           'month_and_year' => $this->month. " / ". $this->year,
           'month' => $this->month,
           'year' => $this->year,
           'name_on_the_card' => $this->name_on_the_card,
           'is_default' => $this->is_default == true ? "Varsayılan" : "",
        ];
    }
}
