<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property int $personel_id
 * @property string $start_time
 * @property string $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $personel
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelStayOffDay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PersonelStayOffDay extends Model
{
    use HasFactory;

    protected $casts = ["start_time" => "datetime", 'end_time' => "datetime"];

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
