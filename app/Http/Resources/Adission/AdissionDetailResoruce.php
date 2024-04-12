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
        $total = calculateTotal($this->services) + $this->sales->sum("total");
        return [
            'id' => $this->id,
            'name' => $this->customer->name,
            'date' => $this->start_time->format('d.m.Y H:i'),
            'status' => $this->status("text"),
            'statusCode' => $this->status,
            'comment_status' => $this->comment_status,
            'note' => $this->note,
            'isCampaign' => isset($this->campaign_id),
            'total' => $total,
            'campaignDiscount' => formatNoIconPrice($this->calculateCampaignDiscount()),//kampanya indirimi
            'cashPoint' =>   formatNoIconPrice($this->point),//kullanılan cash point
            'collectedTotal' => formatNoIconPrice($this->calculateCollectedTotal()),//tahsil edilecek tutar
            'remaining_amount' => formatNoIconPrice($this->remainingTotal()),//kalan tutar
            'earningPoint' => formatNoIconPrice($this->earned_point), //kazanılan parapuan
            'isPermission' => $this->earned_point > 0, //parapuan görünürlük durumu
            'payments' => AdissionPaymentListResoruce::collection($this->payments) //tahsilatlar
        ];
    }
}
