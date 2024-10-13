<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NotificationListResource extends JsonResource
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
          'title' => Str::limit($this->title, 12),
          'description' => $this->message,
          'created_at' => $this->created_at->format('d.m.Y'),
          'created_clock' => $this->created_at->format('H:i'),
          'link' => $this->link,
          'status' => $this->status,
          'icon' => "https://file.hizlirandevu.com.tr/default/notificationIcon.png",
        ];
    }
}
