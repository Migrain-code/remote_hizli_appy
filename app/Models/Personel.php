<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Personel extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

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
    public function restDays()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id')->where('status', 1);
    }
}
