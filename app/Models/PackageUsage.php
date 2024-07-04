<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $package_id
 * @property int $personel_id
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $personel
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageUsage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PackageUsage extends Model
{
    use HasFactory;

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
