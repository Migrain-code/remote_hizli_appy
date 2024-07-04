<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $category_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property-read \App\Models\BusinessCategory|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FeaturedCategoryCity> $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeaturedCategorie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FeaturedCategorie extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasOne(BusinessCategory::class, 'id', 'category_id');
    }

    public function cities()
    {
        return $this->hasMany(FeaturedCategoryCity::class, 'featured_id', 'id');
    }
}
