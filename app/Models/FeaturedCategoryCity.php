<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $featured_id
 * @property int $city_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity whereFeaturedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategoryCity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeaturedCategoryCity extends Model
{
    use HasFactory;
}
