<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentCollectionEntry extends Model
{
    use HasFactory;

    const PAYMENT_TYPES = [
        0 => ["id" => 0, "name" => "Nakit"],
        1 => ["id" => 1, "name" => "Banka / Kredi Kartı"],
        2 => ["id" => 2, "name" => "EFT / Havale"],
        3 => ["id" => 3, "name" => "Diğer"],
    ];

    public function type($type)
    {
        return self::PAYMENT_TYPES[$this->payment_type_id][$type] ?? null;
    }
}
