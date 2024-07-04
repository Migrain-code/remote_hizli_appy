<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceShare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceShare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceShare query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceShare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceShare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceShare whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceShare whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceShare extends Model
{
    use HasFactory;
}
