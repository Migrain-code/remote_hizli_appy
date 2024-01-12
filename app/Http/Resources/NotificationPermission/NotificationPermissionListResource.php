<?php

namespace App\Http\Resources\NotificationPermission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationPermissionListResource extends JsonResource
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
          'is_email' => $this->is_email,
          'is_sms' => $this->is_sms,
          'is_phone' => $this->is_phone,
          'is_notification' => $this->is_notification,
        ];
    }
}
