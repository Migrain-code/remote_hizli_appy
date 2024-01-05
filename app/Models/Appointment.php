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
        ],
        1 => [
            'html' => '<span class="badge light badge-success fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı'
        ],
        2 => [
            'html' => '<span class="badge light badge-info fw-bolder px-2 py-2">Randevu Zamanı</span>',
            'text' => 'Randevu Zamanı'
        ],
        3 => [
            'html' => '<span class="badge light badge-default fw-bolder px-2 py-2">Başladı</span>',
            'text' => 'Başladı'
        ],
        4 => [
            'html' => '<span class="badge badge-outline-success fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı'
        ],
        5 => [
            'html' => '<span class="badge badge-outline-info fw-bolder px-2 py-2">Ödeme Bekleniyor</span>',
            'text' => 'Ödeme Bekleniyor'
        ],
        6 => [
            'html' => '<span class="badge badge-outline-info fw-bolder px-2 py-2">Ödeme Alındı</span>',
            'text' => 'Ödeme Alındı'
        ],
        7 => [
            'html' => '<span class="badge badge-outline-success fw-bolder px-2 py-2">Ödeme Onaylandı</span>',
            'text' => 'Ödeme Onaylandı'
        ],
        8 => [
            'html' => '<span class="badge light badge-danger fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi'
        ],

    ];
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

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }
    public function calculateTotal()
    {
        $total=0;
        foreach ($this->services as $service){
            $total+=$service->service->price;
        }
        return $total;
    }
}
