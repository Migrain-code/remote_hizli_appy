<?php

namespace App\Models;

use App\Services\Sms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 *
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $app_phone
 * @property string|null $email
 * @property int|null $city_id
 * @property int|null $district_id
 * @property int|null $gender
 * @property string|null $image
 * @property string|null $password
 * @property int|null $status
 * @property string|null $birthday
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $verify_phone
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CustomerCashPoint> $cashPoints
 * @property-read int|null $cash_points_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessComment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackageSale> $packageSales
 * @property-read int|null $package_sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSales> $productSales
 * @property-read int|null $product_sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentReceivable> $receivables
 * @property-read int|null $receivables_count
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAppPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereVerifyPhone($value)
 * @mixin \Eloquent
 */
class Customer extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ["password"];
    public function business()
    {
        return $this->hasMany(BusinessCustomer::class, 'customer_id', 'id');
    }
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
        Sms::send($this->phone, $message);
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

    public function withBusinessCashpoints()
    {
        return $this->cashPoints()->where('business_id', authUser()->business_id);
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

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }
}
