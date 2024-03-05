<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCost extends Model
{
    use HasFactory;
    protected $dates = ['operation_date'];
    const PAYMENT_TYPES = [
        0 => ["id" => 0, "name" => "Nakit"],
        1 => ["id" => 1, "name" => "Banka / Kredi Kartı"],
        2 => ["id" => 2, "name" => "EFT / Havale"],
        3 => ["id" => 3, "name" => "Diğer"],
    ];

    public function type()
    {
        return self::PAYMENT_TYPES[$this->payment_type_id] ?? null;
    }
    public function category()
    {
        return $this->hasOne(CostCategory::class, 'id', 'cost_category_id');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
