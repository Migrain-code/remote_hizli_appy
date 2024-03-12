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
    public function appointmentRange()
    {
        return $this->hasOne(AppointmentRange::class, 'id', 'range');
    }
    public function services()
    {
        return $this->hasMany(PersonelService::class, 'personel_id', 'id');
    }
    public function costs()
    {
        return $this->hasMany(BusinessCost::class, 'personel_id', 'id');
    }
    public function notifications()
    {
        return $this->hasMany(PersonelNotification::class, 'personel_id', 'id')->orderBy('created_at')->take(5);
    }
    public function restDays()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id')->where('status', 1);
    }

    public function appointments()
    {
        return $this->hasMany(AppointmentServices::class, 'personel_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'personel_id', 'id');
    }

    public function stayOffDays()
    {
        return $this->hasOne(PersonelStayOffDay::class, 'personel_id', 'id');
    }
    public function checkDateIsOff($getDate)
    {
        // stayOffDays ilişkisini kullanarak izin tarihlerini alıyoruz.
        $offDays = $this->stayOffDays;

        if ($getDate >= $offDays->start_time && $getDate <= $offDays->end_time) {
            return true;
        }
        // Eğer tarih izin tarihleri arasında değilse,false döndürüyoruz.
        return false;
    }
    protected static function booted()
    {
        static::deleted(function ($personel) {
            $personel->notifications()->delete();
            $personel->restDays()->delete();
            $personel->services()->delete();
        });
    }
}
