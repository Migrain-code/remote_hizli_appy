<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $package_id
 * @property string $price
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackagePayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PackagePayment extends Model
{
    use HasFactory;
}
