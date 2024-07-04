<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper query()
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Swiper whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Swiper extends Model
{
    use HasFactory;
}
