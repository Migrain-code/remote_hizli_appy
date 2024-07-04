<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $personel_id
 * @property int $day_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DayList|null $day
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay whereDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelRestDay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PersonelRestDay extends Model
{
    use HasFactory;

    public function day()
    {
        return $this->hasOne(DayList::class, 'id', 'day_id');
    }
}
