<?php

namespace App\Http\Resources\BusinessCloseDay;

use App\Http\Resources\Customer\AbsentListResoruce;
use App\Http\Resources\Personel\PersonelListResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CloseDayEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $statusCodes = [
            0 => [
                "id" => 0,
                'text' => 'Pasif',
                "color" => "#fff04f"
            ],
            1 => [
                "id" => 1,
                'text' => 'Aktif',
                "color" => "#6aab73"
            ],
        ];
        return [
            'id' => $this->id,
            'dayCount' => $this->start_time->diffInDays($this->end_time). " Gün",
            'start_time' => $this->start_time->format('d.m.Y'),
            'end_time' => $this->end_time->format('d.m.Y'),
            'status' => $this->status == 1 ? "Aktif" : "Pasif",
            'statusCode' => $this->status,
            'statusList' => $statusCodes
        ];
    }
}
