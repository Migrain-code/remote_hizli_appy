<?php

namespace App\Http\Resources\Advert;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
          'id' => $this->id,
          'title' => $this->getTitle(),
          'link' => $this->link,
          'icon' => image($this->image)
        ];
    }
}
