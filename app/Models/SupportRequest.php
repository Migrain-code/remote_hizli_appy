<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'due_date' => 'date',
    ];
    const STATUS_LIST = [
        0 => [
            "id" => 0,
            "name" => "İletildi",
            "html" => "<span class='badge badge-light-warning'> İletildi </span>"
        ],
        1 => [
            "id" => 1,
            'name' => "Cevaplandı",
            "html" => "<span class='badge badge-light-success'> Cevaplandı </span>"
        ],
        2 => [
            "id" => 2,
            'name' => "Kapatıldı",
            "html" => "<span class='badge badge-light-danger'> Kapatıldı </span>"
        ],
    ];
    const IMPORTANT_STATUS = [
        1 => [
            "id" => 1,
            "name" => "Çok Acil",
        ],
        2 => [
            "id" => 2,
            'name' => "Biraz Bekleyebilirim",
        ],
        3 => [
            "id" => 3,
            'name' => "Aciliyeti Yok",
        ],
    ];
    const WHY_LIST = [
        1 => [
            "id" => 1,
            "name" => "İşlem Yapamıyorum",
        ],
        2 => [
            "id" => 2,
            'name' => "Kasma Yaşanıyor",
        ],
        3 => [
            "id" => 3,
            'name' => "Sayfa Yüklenmiyor",
        ],
        4 => [
            "id" => 4,
            'name' => "Hesaplamada Hata Var",
        ],
        5 => [
            "id" => 5,
            'name' => "Belirli Alanın Kullanımı Anlamadım",
        ],
        "other" => [
            "id" => "other",
            'name' => "Diğer (Lütfen açıklayınız)",
        ],
    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->is_closed][$type];
    }

    public function important($type)
    {
        return self::IMPORTANT_STATUS[$this->order_number][$type];
    }

    public function why($type)
    {
        return self::WHY_LIST[$this->why_is_it][$type];
    }

    public function user()
    {
        return $this->hasOne(BusinessOfficial::class, 'id', 'user_id');
    }

    public function responses()
    {
        return $this->hasMany(SupportResponse::class, 'support_request_id', 'id');
    }

    protected static function booted(){
        static::deleted(function ($supportRequest){
            $supportRequest->responses()->delete();
        });
    }
}
