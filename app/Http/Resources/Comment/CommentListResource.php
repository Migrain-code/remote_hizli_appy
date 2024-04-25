<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\Customer\CustomerDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentListResource extends JsonResource
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
           'customer' => CustomerDetailResource::make($this->customer),
           'content' => $this->content,
           'point' => $this->point,
           'status' => $this->status == 1,//yayında
           'created_at' => $this->created_at->format('d.m.Y H:i:s')
        ];
    }
}
