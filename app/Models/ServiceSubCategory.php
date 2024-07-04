<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * 
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $image
 * @property array|null $slug
 * @property array $name
 * @property int|null $order_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ServiceCategory|null $category
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceSubCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceSubCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['name', 'slug'];
    public function getName()
    {
        return $this->translate('name');
    }
    public function category()
    {
        return $this->hasOne(ServiceCategory::class,'id', 'category_id');
    }
}
