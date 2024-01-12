<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class BusinessOfficial extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guarded = ['official'];

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function cards()
    {
        return $this->hasMany(OfficialCreatidCard::class, 'official_id', 'id')->latest('is_default');
    }

    public function card()
    {
        return $this->hasOne(OfficialCreatidCard::class, 'official_id', 'id');
    }
    public function permission()
    {
        return $this->hasOne(BusinessNotificationPermission::class, 'business_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(BusinessNotification::class, 'business_id', 'id');
    }
}
