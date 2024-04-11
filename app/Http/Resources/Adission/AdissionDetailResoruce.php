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
        $total = formatPrice(calculateTotal($this->services) + $this->sales->sum("total"));
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
        $total = formatPrice(calculateTotal($this->services) + $this->sales->sum("total"));
        $discounttotal = number_format(($total * $this->discount) / 100, 2);
        return $discounttotal;
    }
    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        $total = formatPrice(calculateTotal($this->services) + $this->sales->sum("total"));
        $recTotal = ceil($total - ((($total * $this->discount) / 100) + $this->point));
        return $recTotal;
    }

    public function remainingTotal() //kalan tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }
}
