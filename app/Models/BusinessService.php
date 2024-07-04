<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property int|null $type
 * @property int $category
 * @property int $sub_category
 * @property string|null $time
 * @property float $price
 * @property int $status
 * @property int $order_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business|null $business
 * @property-read \App\Models\ServiceCategory|null $categorys
 * @property-read \App\Models\BusinnessType $gender
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelService> $personels
 * @property-read int|null $personels_count
 * @property-read \App\Models\ServiceSubCategory $subCategory
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessService extends Model
{
    use HasFactory;

    public function gender()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type')->withDefault([
            'id' => 1,
            'name' => "Cinsiyet Bulunamadı"
        ]);
    }

    public function categorys()
    {
        return $this->hasOne(ServiceCategory::class, 'id', 'category');
    }

    public function subCategory()
    {
        return $this->hasOne(ServiceSubCategory::class, 'id', 'sub_category')->withDefault([
            'name' => "Hizmet Bulunamadı"
        ]);
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id','business_id');
    }

    public function personels()
    {
        return $this->hasMany(PersonelService::class, 'service_id', 'id');
    }
    public function getPrice($room_id = null, $personelPrice = null)
    {
        $price = 0;
        if (isset($room_id)){
            $findRoom = $this->business->rooms()->where('id', $room_id)->first();
            if ($findRoom){
                if (isset($personelPrice)){
                    $price = $personelPrice + (($personelPrice * $findRoom->price) / 100);
                } else{
                    $price = $this->price + (($this->price * $findRoom->price) / 100);
                }
            } else{
                if (isset($personelPrice)){
                    $price = $personelPrice;
                } else{
                    $price = $this->price;
                }

            }
        } else{
            if (isset($personelPrice)){
                $price = $personelPrice;
            } else{
                $price = $this->price_type_id == 0 ? $this->price : $this->price . " - " . $this->max_price;
            }
        }

        return $price;
    }
    protected static function booted()
    {
        static::deleted(function ($businessService) {
            $businessService->personels()->delete();
        });
    }

}
