<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessService extends Model
{
    use HasFactory;

    public function gender()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type')->withDefault([
            'id' => 1,
            'name' => "Cinsiyet Bulunamadı"
        ]);
    }

    public function categorys()
    {
        return $this->hasOne(ServiceCategory::class, 'id', 'category');
    }

    public function subCategory()
    {
        return $this->hasOne(ServiceSubCategory::class, 'id', 'sub_category')->withDefault([
            'name' => "Hizmet Bulunamadı"
        ]);
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id','business_id');
    }

    public function personels()
    {
        return $this->hasMany(PersonelService::class, 'service_id', 'id');
    }

    protected static function booted()
    {
        static::deleted(function ($businessService) {
            $businessService->personels()->delete();
        });
    }

}
