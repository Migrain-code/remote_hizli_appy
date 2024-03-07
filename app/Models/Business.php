<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\AssignOp\Mod;


class Business extends Model
{
    use HasFactory;


    //protected $dates=['start_time', 'end_time'];
    public function package()
    {
        return $this->hasOne(BussinessPackage::class, 'id', 'package_id');
    }

    public function category()
    {
        return $this->hasOne(BusinessCategory::class, 'id', 'category_id');
    }
    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type_id');
    }
    public function range()
    {
        return $this->hasOne(AppointmentRange::class, 'id', 'appoinment_range');
    }
    public function offDay()
    {
        return $this->hasOne(DayList::class, 'id', 'off_day');
    }

    public function workTimes()
    {
        return $this->hasMany(BusinessWorkTime::class, 'business_id', 'id')->orderBy('que');
    }

    public function services()
    {
        return $this->hasMany(BusinessService::class, 'business_id', 'id');

    }

    public function personels()
    {
        return $this->hasMany(Personel::class, 'business_id', 'id')->latest();
    }

    public function costs()
    {
        return $this->hasMany(BusinessCost::class, 'business_id', 'id');
    }
    public function service()
    {
        return $this->hasMany(BusinessService::class, 'business_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(BusinessGallery::class, 'business_id', 'id');
    }

    public function receivables()
    {
        return $this->hasMany(AppointmentReceivable::class, 'business_id', 'id');
    }

    public function depts()
    {
        return $this->hasMany(BusinessDep::class, 'business_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'business_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'business_id', 'id');
    }

    public function packages()
    {
        return $this->hasMany(PackageSale::class, 'business_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(BusinessCustomer::class, 'business_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'business_id', 'id');
    }
    public function promossions()
    {
        return $this->hasOne(BusinessPromossion::class, 'business_id', 'id');
    }
    public function cities()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function districts()
    {
        return $this->hasOne(District::class, 'id', 'district');

    }

    public function notes()
    {
        return $this->hasMany(BusinessNote::class, 'business_id', 'id');
    }

    public function personelNotifications()
    {
        return $this->hasMany(PersonelNotification::class, 'business_id', 'id');
    }

    public function personelStayOffDays()
    {
        return $this->hasMany(PersonelStayOffDay::class, 'business_id', 'id');
    }

    public function officials()
    {
        return $this->hasMany(BusinessOfficial::class, 'company_id', 'company_id');
    }
}
