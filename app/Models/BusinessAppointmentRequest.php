<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAppointmentRequest extends Model
{
    use HasFactory;

    protected $casts = [
        "added_services" => "object",
        "questions" => "object",
        "call_date" => "datetime",
    ];

    const STATUS_LIST = [
        0 => [
            'html' => '<span class="badge badge-warning fw-bolder px-2 py-2" style="color:#fff04f">Bekliyor</span>',
            'text' => 'Bekliyor',
            "color" => "#fff04f"
        ],
        1 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Arandı</span>',
            'text' => 'Arandı',
            "color" => "#6aab73"
        ],
        2 => [
            'html' => '<span class="badge badge-danger fw-bolder px-2 py-2">Aranmadı</span>',
            'text' => 'Aranmadı',
            "color" => "#bf0d36"
        ],
        3 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Sonra Aranacak</span>',
            'text' => 'Sonra Aranacak',
            "color" => "#4a7750"
        ],
        4 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Sms ile Cevaplandı</span>',
            'text' => 'Sms ile Cevaplandı',
            "color" => "#6aab73"
        ],
    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
}
