<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use PhpParser\Node\Expr\AssignOp\Mod;
use Spatie\Permission\Traits\HasRoles;


/**
 *
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $branch_name
 * @property string|null $phone
 * @property string|null $admin_id
 * @property int|null $category_id
 * @property string $company_id
 * @property int|null $package_id
 * @property int $order_number
 * @property string|null $slug
 * @property string $packet_end_date
 * @property string $packet_start_date
 * @property int|null $status
 * @property int $is_main
 * @property int $setup_status
 * @property string $personal_count
 * @property int $commission
 * @property string|null $business_email
 * @property string|null $lat
 * @property string|null $longitude
 * @property int|null $off_day
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $year
 * @property int|null $approve_type
 * @property int|null $appoinment_range
 * @property int|null $type_id
 * @property int|null $city
 * @property int|null $district
 * @property string|null $logo
 * @property string|null $wallpaper
 * @property string|null $about
 * @property string|null $embed
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read \App\Models\BusinessCategory|null $category
 * @property-read \App\Models\City|null $cities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessCost> $costs
 * @property-read int|null $costs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessCustomer> $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessDep> $depts
 * @property-read int|null $depts_count
 * @property-read \App\Models\District|null $districts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessGallery> $gallery
 * @property-read int|null $gallery_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessNote> $notes
 * @property-read int|null $notes_count
 * @property-read \App\Models\DayList|null $offDay
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessOfficial> $officials
 * @property-read int|null $officials_count
 * @property-read \App\Models\BussinessPackage|null $package
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackageSale> $packages
 * @property-read int|null $packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelNotification> $personelNotifications
 * @property-read int|null $personel_notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelStayOffDay> $personelStayOffDays
 * @property-read int|null $personel_stay_off_days_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personel> $personels
 * @property-read int|null $personels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\BusinessPromossion|null $promossions
 * @property-read \App\Models\AppointmentRange|null $range
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentReceivable> $receivables
 * @property-read int|null $receivables_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSales> $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessService> $service
 * @property-read int|null $service_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessService> $services
 * @property-read int|null $services_count
 * @property-read \App\Models\BusinnessType|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessWorkTime> $workTimes
 * @property-read int|null $work_times_count
 * @method static \Illuminate\Database\Eloquent\Builder|Business newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business query()
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereAppoinmentRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereApproveType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereBusinessEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereOffDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business wherePacketEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business wherePacketStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business wherePersonalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereSetupStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereWallpaper($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereYear($value)
 * @mixin \Eloquent
 */
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

    public function invoices()
    {
        return $this->hasMany(PacketOrder::class, 'business_id', 'id');
    }
    public function workTimes()
    {
        return $this->hasMany(BusinessWorkTime::class, 'business_id', 'id')->orderBy('que');
    }

    public function services()
    {
        return $this->allServices()->where('is_delete', 0);
    }
    public function allServices()
    {
        return $this->hasMany(BusinessService::class, 'business_id', 'id');
    }
    public function personels()
    {
        return $this->hasMany(Personel::class, 'business_id', 'id')->whereIsDelete(0)->latest();
    }
    public function rooms()
    {
        return $this->hasMany(BusinessRoom::class, 'business_id', 'id')->whereIsDelete(0);
    }

    public function activeRooms()
    {
        return $this->rooms()->whereStatus(1)->orderBy('is_main', 'desc');
    }
    public function costs()
    {
        return $this->hasMany(BusinessCost::class, 'business_id', 'id');
    }
    public function forms()
    {
        return $this->hasMany(AppointmentRequestForm::class, 'business_id', 'id');
    }
    public function service()
    {
        return $this->hasMany(BusinessService::class, 'business_id', 'id');
    }
    public function requests()
    {
        return $this->hasMany(BusinessAppointmentRequest::class, 'business_id', 'id')->latest();
    }

    public function newRequests()
    {
        //son 3 gün içindeki aranamamış talepleri alır
        return $this->requests()->whereStatus(0)->whereBetween('created_at', [now()->subDays(3), now()]);
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

    public function lowStockProducts()
    {
        return $this->products()->where('piece' ,'<', $this->stock_count);
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
    public function customerGallery()
    {
        return $this->hasMany(CustomerGallery::class, 'business_id', 'id');
    }
    public function official()
    {
        return $this->hasOne(BusinessOfficial::class, 'business_id', 'id')->withDefault([
            'name' => "Yetkilisi Yok"
        ]);
    }

    public function branches()
    {
        return $this->hasMany(Business::class, 'company_id', 'company_id')->where('id','<>', $this->id);
    }

    public function closeDays()
    {
        return $this->hasMany(BusinessCloseDate::class, 'business_id', 'id');
    }

    public function activeCloseDays()
    {
        return $this->closeDays()->where('status', 1);
    }

    public function isClosed($date)
    {
        $closeDate = Carbon::parse($date);
        $businessCloseDates = $this->activeCloseDays;

        $isClosed = $businessCloseDates->contains(function ($closeDateRecord) use ($closeDate) {
            $startTime = Carbon::parse($closeDateRecord->start_time);
            $endTime = Carbon::parse($closeDateRecord->end_time);

            return $closeDate->between($startTime, $endTime);
        });

        return $isClosed;
    }

    public function customWorkTimes()
    {
        return $this->hasMany(PersonelWorkTime::class, 'business_id', 'id');
    }
}
