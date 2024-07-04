<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property float $percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCut whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceCut extends Model
{
    use HasFactory;
}
