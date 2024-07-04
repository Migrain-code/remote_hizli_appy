<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int|null $business_id
 * @property int|null $customer_id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int|null $status
 * @property float $total
 * @property int $discount
 * @property int|null $campaign_id
 * @property float $point
 * @property float $earned_point kazanılan puan
 * @property string|null $note
 * @property int $comment_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_verify_phone
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\CustomerCashPoint|null $cashPoint
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentCollectionEntry> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentPhoto> $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentReceivable> $receivables
 * @property-read int|null $receivables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSales> $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentServices> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCommentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereEarnedPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereIsVerifyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Appointment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Appointment extends Model
{
    use HasFactory;

    protected $casts = ['start_time' => "datetime", 'end_time' => "datetime"];

    const STATUS_LIST = [
        0 => [
            'html' => '<span class="badge badge-warning fw-bolder px-2 py-2" style="color:#fff04f">Onay Bekliyor</span>',
            'text' => 'Onay Bekliyor',
            "color" => "#fff04f"
        ],
        1 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Onaylandı</span>',
            'text' => 'Onaylandı',
            "color" => "#6aab73"
        ],
        2 => [
            'html' => '<span class="badge badge-success fw-bolder px-2 py-2">Tamamlandı</span>',
            'text' => 'Tamamlandı',
            "color" => "#4a7750"
        ],
        3 => [
            'html' => '<span class="badge badge-danger fw-bolder px-2 py-2">İptal Edildi</span>',
            'text' => 'İptal Edildi',
            "color" => "#bf0d36"
        ],
        4 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Gelmedi</span>',
            'text' => 'Gelmedi',
            "color" => "#bf0d36"
        ],
        5 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Geldi</span>',
            'text' => 'Geldi',
            "color" => "#4a7750"
        ],
        6 => [
            'html' => '<span class="badge badge-info fw-bolder px-2 py-2">Tahsilatsız Kapatıldı</span>',
            'text' => 'Tahsilatsız Kapatıldı',
            "color" => "#2f4aaf"
        ],

    ];

    public function status($type)
    {
        return self::STATUS_LIST[$this->status][$type] ?? null;
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri"
        ]);
    }

    public function campaign()
    {
        return $this->hasOne(Campaign::class, 'id', 'campaign_id');
    }

    public function room()
    {
        return $this->hasOne(BusinessRoom::class, 'id', 'room_id');
    }

    public function services()
    {
        return $this->hasMany(AppointmentServices::class, 'appointment_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(AppointmentCollectionEntry::class, 'appointment_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(AppointmentPhoto::class, 'appointment_id', 'id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }

    public function cashPoint()
    {
        return $this->hasOne(CustomerCashPoint::class, 'appointment_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'appointment_id', 'id');
    }

    public function receivables()
    {
        return $this->hasMany(AppointmentReceivable::class, 'appointment_id', 'id');
    }

    public function addCashPoint()
    {
        if (isset($this->cashPoint)) {
            return false;
        }

        $customerCashPoint = new CustomerCashPoint();
        $customerCashPoint->appointment_id = $this->id;
        $customerCashPoint->customer_id = $this->customer_id;
        $customerCashPoint->business_id = $this->business_id;
        $customerCashPoint->price = $this->earned_point;
        $customerCashPoint->addition_date = now();
        if ($customerCashPoint->save()) {
            return true;

        }
    }

    public function calculateAppointmentEarnedPoint()
    {
        $promossion = $this->business->promossions;
        $discountRate = 0;
        $discountRate = $promossion->cash;

        //dd($discountRate);
        $discountTotal = ($this->calculateTotal() * $discountRate) / 100;
        return $discountTotal;

    }

    public function calculateTotal() // toplam hizmet hiyatı
    {
        $total = 0;
        $rangePrice = false;
        foreach ($this->services as $service) {
            $servicePrice = $service->servicePrice();
            if (is_numeric($servicePrice)){
                $total+= $servicePrice;
            } else{
                $rangePrice = true;
                $total = "Hesaplanacak";
            }
        }
        if ($rangePrice){
            return $total;
        }
        return $total;
    }

    function totalServiceAndProduct()
    { // toplam ürün ve hizmet satışı
        if (is_numeric($this->calculateTotal())){
            return $this->calculateTotal() + $this->sales->sum('total');
        }
        return 0;
    }

    public function calculateCampaignDiscount()
    { //kampanya indirimi
        $total = (($this->totalServiceAndProduct() * $this->discount) / 100);
        return $total;
    }

    public function calculateCollectedTotal() //tahsil edilecek tutar
    {
        $total = $this->totalServiceAndProduct() - $this->calculateCampaignDiscount() - $this->point;
        return $total;
    }

    public function remainingTotal() //kalan  tutar
    {
        return ($this->calculateCollectedTotal() - $this->payments->sum("price")) - $this->receivables()->whereStatus(1)->sum('price');
    }
}
