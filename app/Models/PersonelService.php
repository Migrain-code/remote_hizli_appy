<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $personel_id
 * @property int $service_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $personel
 * @property-read \App\Models\BusinessService|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PersonelService extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id');
    }
    public function personel(){
        return $this->hasOne(Personel::class,'id', 'personel_id');
    }
}
