<?php

namespace App\Http\Resources\Gallery;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryListResource extends JsonResource
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
            'image' => image($this->way),
        ];
    }
}
