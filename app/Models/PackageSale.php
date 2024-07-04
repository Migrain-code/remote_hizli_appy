<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property string $seller_date
 * @property int $customer_id
 * @property int $service_id
 * @property int $personel_id
 * @property int $type
 * @property int $amount
 * @property float $total
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackagePayment> $payeds
 * @property-read int|null $payeds_count
 * @property-read \App\Models\Personel|null $personel
 * @property-read \App\Models\BusinessService|null $service
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackageUsage> $usages
 * @property-read int|null $usages_count
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereSellerDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageSale whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PackageSale extends Model
{
    use HasFactory;


    protected $casts = ["seller_date" => "datetime"];
    const PACKAGE_TYPES = [
        0 => ["id" => 0, "name" => "Seans"],
        1 => ["id" => 1, "name" => "Dakika"],
    ];

    public function formatDate()
    {
        return Carbon::parse($this->seller_date)->format('d.m.Y');
    }

    public function packageType($type)
    {
        return self::PACKAGE_TYPES[$this->type][$type] ?? null;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri",
        ]);
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }

    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id');
    }

    public function usages()
    {
        return $this->hasMany(PackageUsage::class, 'package_id', 'id');
    }

    public function payeds()
    {
        return $this->hasMany(PackagePayment::class, 'package_id', 'id');
    }

    public function policies()
    {
        return $this->hasMany(PackageSalePolicy::class, 'package_sale_id', 'id');
    }

    protected static function booted()
    {
        static::deleted(function ($personel) {
            $personel->usages()->delete();
            $personel->payeds()->delete();
        });
    }
}
