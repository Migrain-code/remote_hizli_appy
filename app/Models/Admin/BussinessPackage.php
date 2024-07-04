<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin\BussinessPackagePropartie> $proparties
 * @property-read int|null $proparties_count
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessPackage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BussinessPackage extends Model
{
    use HasFactory;

    public function proparties()
    {
        return $this->hasMany(BussinessPackagePropartie::class, 'package_id', 'id');
    }
}
