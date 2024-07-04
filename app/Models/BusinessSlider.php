<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessSlider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessSlider extends Model
{
    use HasFactory;
}
