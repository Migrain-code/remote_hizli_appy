<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPromossion extends Model
{
    use HasFactory;

    const PAYMENT_TYPES = [
        0 => [
            "id" => 0,
            "name" => "Parapuan Kullanımı (Nakit)",
            "form_name" => "cash",
        ],
        1 => [
            "id" => 1,
            "name" => "Parapuan Kullanımı (Kredi Kartı)",
            "form_name" => "creditCard",
        ],
        2 => [
            "id" => 2,
            "name" => "Parapuan Kullanımı (EFT / Havale)",
            "form_name" => "eft",
        ],
        3 => [
            "id" => 3,
            "name" => "Parapuan Kullanımı Limiti",
            "form_name" => "limit",
        ],
        4 => [
            "id" => 4,
            "name" => "Doğum Günü İndirimi",
            "form_name" => "birthday",
        ],
    ];

    public function type($type)
    {
        return self::PAYMENT_TYPES[$this->payment_type][$type] ?? null;
    }
}
