<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public function officials()
    {
        return $this->hasMany(CouponOfficial::class, 'coupon_id', 'id');
    }
    protected static function booted()
    {
        static::deleted(function ($coupon) {
            $coupon->officials()->delete();
        });
    }
}
