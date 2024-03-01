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
            "form_name" => "promossion_". 0,
        ],
        1 => [
            "id" => 1,
            "name" => "Parapuan Kullanımı (Kredi Kartı)",
            "form_name" => "promossion_". 1,
        ],
        2 => [
            "id" => 2,
            "name" => "Parapuan Kullanımı (EFT / Havale)",
            "form_name" => "promossion_". 2,
        ],
        3 => [
            "id" => 3,
            "name" => "Parapuan Kullanımı Limiti",
            "form_name" => "promossion_". 3,
        ],
        4 => [
            "id" => 4,
            "name" => "Doğum Günü İndirimi",
            "form_name" => "promossion_". 4,
        ],
        5 => [
            "id" => 5,
            "name" => "Online Randevu İndirimi",
            "form_name" => "promossion_". 5,
        ]
    ];

    public function type($type)
    {
        return self::PAYMENT_TYPES[$this->payment_type][$type] ?? null;
    }
}
