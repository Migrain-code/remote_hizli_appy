<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentServices extends Model
{
    use HasFactory;
    protected $dates=['start_time', 'end_time'];

    const STATUS_LIST=[
        0 => [
            'html' => '<span class="badge light badge-warning fw-bolder px-2 py-2">Onay Bekliyor</span>',
            'text' => 'Onay Bekliyor',
            "color" => "#fff04f"
        ],
        1 => [
            'html' => '<span class="badge light badge-success fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı',
            "color" => "#6aab73"
        ],
        2 => [
            'html' => '<span class="badge badge-outline-success fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı',
            "color" => "#4a7750"
        ],
        3 => [
            'html' => '<span class="badge light badge-danger fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi',
            "color" => "#bf0d36"
        ],
    ];
    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }
    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'id', 'appointment_id');
    }
    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
