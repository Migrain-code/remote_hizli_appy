<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessOfficialResource extends JsonResource
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
          'name' => $this->name,
          'phone' => $this->phone,
          'email' => $this->email,
          'verify_phone' => $this->verify_phone == "1" ? true : false,
          'business' => new BusinessResource($this->business),
        ];
    }
}
