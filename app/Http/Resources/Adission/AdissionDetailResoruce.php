<?php

namespace App\Http\Resources\Adission;

use Illuminate\Http\Resources\Json\JsonResource;

class AdissionDetailResoruce extends JsonResource
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
            'name' => $this->customer->name,
            'date' => $this->start_time->format('d.m.Y H:i'),
            'status' => $this->status("text"),
            'statusCode' => $this->status,
            'comment_status' => $this->comment_status,
            'note' => $this->note,
            'isCampaign' => isset($this->campaign_id),
            'total' => $this->total,
            'campaignDiscount' => $this->calculateCampaignDiscount(),//kampanya indirimi
            'cashPoint' =>  $this->point,//kullanılan cash point
            'collectedTotal' => $this->calculateCollectedTotal(),//tahsil edilecek tutar
            'remaining_amount' => $this->remainingTotal(),//kalan tutar
            'earningPoint' => $this->earned_point, //kazanılan parapuan
            'isPermission' => $this->earned_point > 0, //parapuan görünürlük durumu
            'payments' => AdissionPaymentListResoruce::collection($this->payments) //tahsilatlar
        ];
    }
    public function calculateCampaignDiscount(){ //indirim tl dönüşümü
        $total = number_format(($this->total * $this->discount) / 100, 2);
        return $total;
    }
    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        $total = ceil($this->total - ((($this->total * $this->discount) / 100) + $this->point));
        return $total;
    }

    public function remainingTotal() //kalan  tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }
}
