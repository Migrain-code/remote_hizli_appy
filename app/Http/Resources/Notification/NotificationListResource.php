<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
          'title' => $this->title,
          'description' => $this->message,
          'created_at' => $this->created_at->format('d.m.Y'),
          'created_clock' => $this->created_at->format('H:i'),
          'link' => $this->link,
          'status' => $this->status,
          'icon' => "asd",
        ];
    }
}
