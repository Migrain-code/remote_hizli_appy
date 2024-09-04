<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Passport\HasApiTokens;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property int|null $safe
 * @property int $status 0 => passive 1=> active
 * @property string $name
 * @property string|null $image
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property int|null $accept
 * @property int $rest_day
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $food_start
 * @property string|null $food_end
 * @property string $gender
 * @property int $rate
 * @property int $product_rate
 * @property string $range
 * @property string|null $description
 * @property int $accepted_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AppointmentRange|null $appointmentRange
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AppointmentServices> $appointments
 * @property-read int|null $appointments_count
 * @property-read \App\Models\Business|null $business
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessCost> $costs
 * @property-read int|null $costs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelRestDay> $restDays
 * @property-read int|null $rest_days_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSales> $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelService> $services
 * @property-read int|null $services_count
 * @property-read \App\Models\PersonelStayOffDay|null $stayOffDays
 * @property-read \App\Models\BusinnessType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Personel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereAccept($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereAcceptedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereFoodEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereFoodStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereProductRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereRestDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereSafe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function priceList()
    {
        return $this->hasMany(PersonelCustomerPriceList::class, 'personel_id', 'id');
    }

    public function existCustomPrice($serviceId)
    {
        return $this->priceList()->where('business_service_id', $serviceId)->first();
    }

    public function permission()
    {
        return $this->hasOne(PersonelNotificationPermission::class, 'personel_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(PersonelNotification::class, 'personel_id', 'id')->latest()->take(50);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('status', 0);
    }

    public function isNotificationStatus()
    {
        if ($this->unreadNotifications->count() > 0) {
            return true;
        }
        return false;
    }

    public function notificationMenu()
    {
        return $this->hasMany(PersonelNotification::class, 'personel_id', 'id')->orderBy('created_at', 'desc')->take(10);
    }

    public function restDays()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id')->where('status', 1);
    }

    public function rooms()
    {
        return $this->hasMany(PersonelRoom::class, 'personel_id', 'id');
    }

    public function restDayAll()
    {
        return $this->hasMany(PersonelRestDay::class, 'personel_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(AppointmentServices::class, 'personel_id', 'id');
    }

    public function todayAppointments()
    {
        return $this->appointments()->whereDate('start_time', now()->toDateString())->orderBy('start_time', 'asc');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'personel_id', 'id');
    }

    public function packages()
    {
        return $this->hasMany(PackageSale::class, 'personel_id', 'id');
    }

    public function totalServicePrice()
    {
        $servicePrice = 0;
        foreach ($this->appointments as $appointment) {
            $servicePrice += $appointment->service->price;
        }
        $totalServiceRate = (($servicePrice * $this->rate) / 100);
        return $totalServiceRate;
    }

    public function totalSalePrice()
    {
        $productPrice = $this->sales->sum('total');
        $totalSaleRate = (($productPrice * $this->product_rate) / 100);
        return $totalSaleRate;
    }

    public function totalPrim()
    {
        return $this->totalServicePrice() + $this->totalSalePrice();
    }

    public function getMonthlyPackageSales()
    {
        $sales = [];
        for ($i = 1; $i <= 12; $i++) {
            $sales[] = $this->packages()->whereMonth('seller_date', $i)->count();
        }
        return $sales;
    }

    public function getMonthlyProductSales()
    {
        $sales = [];
        for ($i = 1; $i <= 12; $i++) {
            $sales[] = $this->sales()->whereMonth('created_at', $i)->sum('piece');
        }
        return $sales;
    }

    public function stayOffDays()
    {
        return $this->hasMany(PersonelStayOffDay::class, 'personel_id', 'id');
    }

    public function checkDateIsOff($getDate)
    {
        // stayOffDays ilişkisini kullanarak izin tarihlerini alıyoruz.
        $getDate = Carbon::parse($getDate)->format('Y-m-d');
        $offDays = $this->stayOffDays();
        if ($offDays->count() > 0) {
            $existLeave = $offDays->whereDate('start_time', '<=', $getDate)
                ->whereDate('end_time', '>=', $getDate)
                ->first();
            if ($existLeave) {
                return true;
            }
        }
        // Eğer tarih izin tarihleri arasında değilse,false döndürüyoruz.
        return false;
    }

    public function getCustomer()
    {
        $customer_ids = [];
        foreach ($this->appointments as $appointment) {
            $customer_ids[] = $appointment->appointment->customer_id;
        }
        $customerCount = count(array_unique($customer_ids));
        return $customerCount;
    }

    public function workTimes()
    {
        return $this->hasMany(PersonelWorkTime::class, 'personel_id', 'id');
    }

    public function activeWorkTimes()
    {
        return $this->workTimes()->where('status', 1);
    }
    public function device()
    {
        return $this->hasOne(Device::class, 'customer_id', 'id')->where('type', 2);
    }

    public function isCustomWorkTime($date)
    {
        $closeDate = Carbon::parse($date);
        $personelWorkTimes = $this->activeWorkTimes;

        $isClosed = $personelWorkTimes->first(function ($closeDateRecord) use ($closeDate) {
            $startTime = Carbon::parse($closeDateRecord->start_date);
            $endTime = Carbon::parse($closeDateRecord->end_date);

            return $closeDate->between($startTime, $endTime);
        });

        return $isClosed;
    }

    protected static function booted()
    {
        static::deleted(function ($personel) {
            $personel->notifications()->delete();
            $personel->restDays()->delete();
            $personel->services()->delete();
        });
    }

    public function totalCiro($request = null)
    {
        $productPrice = $this->sales()->when(filled($request), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('created_at', [$startOfYear, $endOfYear]);
            } elseif ($request->listType == "thisDay") {
                $q->whereDate('created_at', now()->toDateString());
            } else {
                $q->whereDate('created_at', now()->subDays(1)->toDateString());
            }
        })->sum('total');
        $packagePrice = $this->packages()->when(filled($request), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('seller_date', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('seller_date', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('seller_date', [$startOfYear, $endOfYear]);
            } elseif ($request->listType == "thisDay") {
                $q->whereDate('created_at', now()->toDateString());
            } else {
                $q->whereDate('seller_date', now()->subDays(1)->toDateString());
            }
        })->sum('total');
        $appointments = $this->appointments()->when(filled($request), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('start_time', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('start_time', [$startOfYear, $endOfYear]);
            } elseif ($request->listType == "thisDay") {
                $q->whereDate('created_at', now()->toDateString());
            } else {
                $q->whereDate('start_time', now()->subDays(1)->toDateString());
            }
        })->get();
        $servicePrice = 0;
        foreach ($appointments as $appointment) {
            $servicePrice += $appointment->service->price;
        }

        return $productPrice + $servicePrice + $packagePrice;

    }

    public function totalBalance($request = null)//toplam cirosu yani satışları
    {
        $productPrice = $this->sales()->when(filled($request), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('created_at', [$startOfYear, $endOfYear]);
            } elseif ($request->listType == "thisDay") {
                $q->whereDate('created_at', now()->toDateString());
            } else {
                $q->whereDate('created_at', now()->subDays(1)->toDateString());
            }
        })->sum('total');
        $packagePrice = $this->packages()->when(filled($request), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('seller_date', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('seller_date', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('seller_date', [$startOfYear, $endOfYear]);
            } elseif ($request->listType == "thisDay") {
                $q->whereDate('created_at', now()->toDateString());
            } else {
                $q->whereDate('seller_date', now()->subDays(1)->toDateString());
            }
        })->sum('total');
        $appointments = $this->appointments()->when(filled($request), function ($q) use ($request) {
            if ($request->listType == "thisWeek") {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                $q->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
            } elseif ($request->listType == "thisMonth") {
                $startOfMonth = now()->startOfMonth();
                $endOfMonth = now()->endOfMonth();
                $q->whereBetween('start_time', [$startOfMonth, $endOfMonth]);
            } elseif ($request->listType == "thisYear") {
                $startOfYear = now()->startOfYear();
                $endOfYear = now()->endOfYear();
                $q->whereBetween('start_time', [$startOfYear, $endOfYear]);
            } elseif ($request->listType == "thisDay") {
                $q->whereDate('created_at', now()->toDateString());
            } else {
                $q->whereDate('start_time', now()->subDays(1)->toDateString());
            }
        })->get();
        $servicePrice = 0;
        foreach ($appointments as $appointment) {
            $servicePrice += $appointment->service->price;
        }

        $hizmetHakedis = ($servicePrice * $this->rate) / 100;
        $satisHakedis = (($productPrice + $packagePrice) * $this->product_rate) / 100;

        return $hizmetHakedis + $satisHakedis;
    }

    public function case($listType = null, $startDate = null, $endDate = null )
    {
        return [
            'appointmentTotal' => $this->calculateAppointmentsTotal($listType, $startDate, $endDate),
            'productSaleTotal' => $this->calculateProductSaleTotal($listType,  $startDate, $endDate),
            'packageSaleTotal' => $this->calculatePackageTotal($listType,  $startDate, $endDate),
            'generalTotal' => $this->generalTotal($listType,  $startDate, $endDate)
        ];
    }

    public function calculateAppointmentsTotal($listType = null, $startDate = null, $endDate = null)
    {
        $appointments = $this->appointments()
            ->when(isset($startDate), function ($q) use ($startDate, $endDate) {
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::parse($endDate);
                $q->whereBetween('start_time', [$startDate->toDateString(), $endDate->toDateString()]);
            })
            ->when($listType, function ($q) use ($listType) {
                switch ($listType) {
                    case 'thisWeek':
                        $q->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'thisMonth':
                        $q->whereBetween('start_time', [now()->startOfMonth(), now()->endOfMonth()]);
                        break;
                    case 'thisYear':
                        $q->whereBetween('start_time', [now()->startOfYear(), now()->endOfYear()]);
                        break;
                    case 'thisDay':
                        $q->whereDate('start_time', now()->toDateString());
                        break;
                    default:
                        $q->whereDate('start_time', now()->subDays(1)->toDateString());
                        break;
                }
            })->get();

        /*foreach ($appointments as $appointment){
            $appointment->total = $appointment->servicePrice();
            $appointment->save();
        }*/
        $servicePrice = $appointments->sum(function ($appointment) {
            return $appointment->total;
        });

        $hizmetHakedis = ($servicePrice * $this->rate) / 100;
        return [
            'appointmentCiro' => $servicePrice,
            'appointmentRate' => $hizmetHakedis,
            'rate' => '%' . $this->rate,
        ];
    }

    public function calculateProductSaleTotal($listType = null, $startDate = null, $endDate = null)
    {
        $productPrice = $this->sales()
            ->when(isset($startDate), function ($q) use ($startDate, $endDate) {
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::parse($endDate);
                $q->whereBetween('created_at', [$startDate->toDateString(), $endDate->toDateString()]);
            })
            ->when($listType, function ($q) use ($listType) {
                switch ($listType) {
                    case 'thisWeek':
                        $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'thisMonth':
                        $q->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                        break;
                    case 'thisYear':
                        $q->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
                        break;
                    case 'thisDay':
                        $q->whereDate('created_at', now()->toDateString());
                        break;
                    default:
                        $q->whereDate('created_at', now()->subDays(1)->toDateString());
                        break;
                }
            })->sum('total');

        $productHakedis = ($productPrice * $this->product_rate) / 100;
        return [
            'productSaleCiro' => $productPrice,
            'productSaleRate' => $productHakedis,
            'rate' => '%' . $this->product_rate,
        ];
    }

    public function calculatePackageTotal($listType = null, $startDate = null, $endDate = null)
    {
        $packagePrice = $this->packages()
            ->when(isset($startDate), function ($q) use ($startDate, $endDate) {
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::parse($endDate);
                $q->whereBetween('seller_date', [$startDate->toDateString(), $endDate->toDateString()]);
            })
            ->when($listType, function ($q) use ($listType) {
                switch ($listType) {
                    case 'thisWeek':
                        $q->whereBetween('seller_date', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'thisMonth':
                        $q->whereBetween('seller_date', [now()->startOfMonth(), now()->endOfMonth()]);
                        break;
                    case 'thisYear':
                        $q->whereBetween('seller_date', [now()->startOfYear(), now()->endOfYear()]);
                        break;
                    case 'thisDay':
                        $q->whereDate('seller_date', now()->toDateString());
                        break;
                    default:
                        $q->whereDate('seller_date', now()->subDays(1)->toDateString());
                        break;
                }
            })->sum('total');

        $packageHakedis = ($packagePrice * $this->product_rate) / 100;
        return [
            'packageSaleCiro' => $packagePrice,
            'packageSaleRate' => $packageHakedis,
            'rate' => '%' . $this->product_rate,
        ];
    }

    public function generalTotal($listType = null, $startDate = null, $endDate = null)
    {
        $appointmentTotal = $this->calculateAppointmentsTotal($listType, $startDate, $endDate);
        $productSaleTotal = $this->calculateProductSaleTotal($listType, $startDate, $endDate);
        $packageSaleTotal = $this->calculatePackageTotal($listType, $startDate, $endDate);

        $totalCiro = $appointmentTotal['appointmentCiro'] + $productSaleTotal['productSaleCiro'] + $packageSaleTotal['packageSaleCiro'];
        $totalHakedis = $appointmentTotal['appointmentRate'] + $productSaleTotal['productSaleRate'] + $packageSaleTotal['packageSaleRate'];

        return [
            'totalCiro' => $totalCiro,
            'totalRate' => $totalHakedis,
        ];
    }

    public function calculatePayedBalance()
    {
        $costs = $this->costs()->where('cost_category_id', 1)->get();
        return $costs;
    }

    public function insideBalance()
    {
        return number_format($this->totalBalance() - $this->calculatePayedBalance()->sum('price'), 2);
    }
}
