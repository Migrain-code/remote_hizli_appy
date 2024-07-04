<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinnessType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinnessType extends Model
{
    use HasFactory;
}
