<?php

namespace App\Http\Resources\Branches;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessBrancesResource extends JsonResource
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
           'name' => $this->branch_name ?? $this->name,
        ];
    }
}
