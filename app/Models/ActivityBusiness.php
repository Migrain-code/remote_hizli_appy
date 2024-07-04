<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $activity_id
 * @property int $personel_id
 * @property string|null $activity_code
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $personel
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness whereActivityCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityBusiness whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivityBusiness extends Model
{
    use HasFactory;

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
