<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    use HasFactory;

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'gender');
    }

    public function services()
    {
        return $this->hasMany(PersonelService::class, 'personel_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(PersonelNotification::class, 'personel_id', 'id')->orderBy('created_at')->take(5);
    }
    public function restDay()
    {
        return $this->hasOne(DayList::class, 'id', 'rest_day');
    }
}
