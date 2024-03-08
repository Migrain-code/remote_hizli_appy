<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSales extends Model
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
        return self::PAYMENT_TYPES[$this->payment_type][$type] ?? null;
    }
    public function customer()
    {
        return $this->hasOne(Customer::class,'id', 'customer_id')->withDefault([
            'name' => 'Silinmiş Müşteri',
        ]);
    }
    public function business()
    {
        return $this->hasOne(Business::class,'id', 'business_id')->withDefault([
            'name' => 'Silinmiş İşletme',
        ]);
    }
    public function personel()
    {
        return $this->hasOne(Personel::class,'id', 'personel_id')->withDefault([
            'name' => "Silinmiş Personel"
        ]);
    }
    public function product()
    {
        return $this->hasOne(Product::class,'id', 'product_id')->withDefault([
            'name' => "Silinmiş Ürün"
        ]);
    }

}
