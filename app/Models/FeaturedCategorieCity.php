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
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity whereFeaturedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorieCity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeaturedCategorieCity extends Model
{
    use HasFactory;
}
