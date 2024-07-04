<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property int|null $appointment_id
 * @property int $customer_id
 * @property int $product_id
 * @property int $personel_id
 * @property int $payment_type
 * @property int $piece
 * @property float $total
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $business
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Personel $personel
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales wherePiece($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSales whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
