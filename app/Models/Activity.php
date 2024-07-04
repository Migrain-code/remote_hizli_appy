<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property int $city_id
 * @property string|null $hotel_name
 * @property string|null $end_time
 * @property string|null $start_time
 * @property string $image
 * @property string|null $embed
 * @property string|null $phone
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ActivityBusiness> $personels
 * @property-read int|null $personels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ActivitySponsor> $sponsors
 * @property-read int|null $sponsors_count
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereHotelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use HasFactory;
    protected $dates=['start_date', 'stop_date'];

    public function personels()
    {
        return $this->hasMany(ActivityBusiness::class, 'activity_id', 'id');
    }
    public function sponsors()
    {
        return $this->hasMany(ActivitySponsor::class, 'activity_id', 'id')->latest();
    }
}
