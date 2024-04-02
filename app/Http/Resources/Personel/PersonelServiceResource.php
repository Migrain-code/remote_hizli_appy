<?php

namespace App\Http\Resources\Personel;

use App\Http\Resources\Business\BusinessServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonelServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "businessServiceId" => $this->service?->id,
            "business_service" => new BusinessServiceResource($this->service),
        ];
    }
}
