<?php

namespace App\Models;

use App\Services\Sms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'customer_id', 'id');
    }

    public function daysLeft()
    {
        $birthdate = Carbon::parse($this->birthday);
        $now = Carbon::now();
        $birthdate->year($now->year);

        if ($birthdate->isPast()) {
            return 0;
            /*$birthdate->addYear();//bir sonraki yıla kalan süre*/
        }
        $daysLeft = $now->diffInDays($birthdate, true);

        return $daysLeft;
    }
    public function sendSms($message)
    {
        $clean_phone_number = preg_replace('/[^0-9]/', '', $this->email);
        Sms::send($clean_phone_number, $message);
        return true;
    }

    public function sendNotification($title, $content)
    {
        $customerNotification = new CustomerNotificationMobile();
        $customerNotification->customer_id = $this->id;
        $customerNotification->title = $title;
        $customerNotification->slug = Str::slug(uniqid());
        $customerNotification->content = $content;
        $customerNotification->notification_id = 1;
        $customerNotification->save();

        return $customerNotification;
    }

    public function cashPoints()
    {
        return $this->hasMany(CustomerCashPoint::class, 'customer_id', 'id')->where('price', '>', 0);
    }

    public function productSales()
    {
        return $this->hasMany(ProductSales::class, 'customer_id', 'id');
    }

    public function packageSales()
    {
        return $this->hasMany(PackageSale::class, 'customer_id', 'id');
    }

    public function receivables()
    {
        return $this->hasMany(AppointmentReceivable::class, 'customer_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(BusinessComment::class, 'customer_id', 'id');
    }
}
