<?php

namespace App\Http\Resources\Business;

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
          'id' => $this->id,
          'name' => $this->name,
          'phone' => $this->phone,
          'email' => $this->email,
          'verify_phone' => $this->verify_phone == 1 ? true : false,
          'is_admin' => $this->is_admin == 1,
          'business' => new BusinessResource($this->business),
          'user_type' => 0,
        ];
    }
}
