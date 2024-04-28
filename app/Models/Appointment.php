<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $dates=['start_time', 'end_time'];

    const STATUS_LIST=[
        0 => [
            'html' => '<span class="badge light badge-warning fw-bolder px-2 py-2">Onay Bekliyor</span>',
            'text' => 'Onay Bekliyor',
            "color" => "#FFEAB7"
        ],
        1 => [
            'html' => '<span class="badge light badge-success fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı',
            "color" => "#D4F0F4"
        ],
        2 => [
            'html' => '<span class="badge badge-outline-success fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı',
            "color" => "#D4F0F4"
        ],
        3 => [
            'html' => '<span class="badge light badge-danger fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi',
            "color" => "#FFB7B7"
        ],
        4 => [
            'html' => '<span class="badge badge-outline-info fw-bolder px-2 py-2">Gelmedi</span>',
            'text' => 'Gelmedi',
            "color" => "#FFB7B7"
        ],
        5 => [
            'html' => '<span class="badge badge-outline-info fw-bolder px-2 py-2">Geldi</span>',
            'text' => 'Geldi',
            "color" => "#D4F0F4"
        ],
        6 => [
            'html' => '<span class="badge badge-outline-info fw-bolder px-2 py-2">Tahsilatsız Kapatıldı</span>',
            'text' => 'Tahsilatsız Kapatıldı',
            "color" => "#FFEAB7"
        ],

    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri"
        ]);
    }
    public function services()
    {
        return $this->hasMany(AppointmentServices::class, 'appointment_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(AppointmentCollectionEntry::class, 'appointment_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(AppointmentPhoto::class, 'appointment_id', 'id');
    }
    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
    public function cashPoint()
    {
        return $this->hasOne(CustomerCashPoint::class, 'appointment_id', 'id');
    }
    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'appointment_id', 'id');
    }

    public function receivables()
    {
        return $this->hasMany(AppointmentReceivable::class, 'appointment_id', 'id');
    }
    public function addCashPoint()
    {
        if(isset($this->cashPoint)){
            return false;
        }

        $customerCashPoint = new CustomerCashPoint();
        $customerCashPoint->appointment_id = $this->id;
        $customerCashPoint->customer_id = $this->customer_id;
        $customerCashPoint->business_id = $this->business_id;
        $customerCashPoint->price = $this->earned_point;
        $customerCashPoint->addition_date = now();
        if ($customerCashPoint->save()){
            return true;

        }
    }
    public function calculateTotal()
    {
        $total=0;
        foreach ($this->services as $service){
            $total+=$service->service->price;
        }
        return $total;
    }

    function totalServiceAndProduct(){ // toplam ürün ve hizmet satışı
        return $this->calculateTotal() + $this->sales->sum('total');
    }
    public function calculateCampaignDiscount(){ //kampanya indirimi
        $total = (($this->totalServiceAndProduct() * $this->discount) / 100);
        return $total;
    }
    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        $total = $this->totalServiceAndProduct() - $this->calculateCampaignDiscount() - $this->point;
        return $total;
    }

    public function remainingTotal() //kalan  tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }
}
