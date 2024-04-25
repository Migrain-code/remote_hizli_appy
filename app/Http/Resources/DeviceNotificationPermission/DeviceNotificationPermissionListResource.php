<?php

namespace App\Http\Resources\DeviceNotificationPermission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceNotificationPermissionListResource extends JsonResource
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
          'is_me' => $this->is_me ?? 0,
          'is_all' => $this->is_all ?? 0,
          'is_customer' => $this->is_customer ?? 0,
          'is_personel' => $this->is_personel ?? 0,
        ];
    }
}
