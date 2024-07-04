<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $fullname
 * @property string $business_name
 * @property string $phone
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessInfo extends Model
{
    use HasFactory;
}
