<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * 
 *
 * @property int $id
 * @property int|null $order_number
 * @property array $name
 * @property array|null $slug
 * @property string|null $image
 * @property string|null $cover_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServiceSubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @property-read mixed $translations
 * @property-read \App\Models\BusinnessType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServiceCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable=['type_id', 'name'];

    protected $translatable = ['name', 'slug'];
    public function getName()
    {
        return $this->translate('name');
    }
    public function subCategories()
    {
        return $this->hasMany(ServiceSubCategory::class,'category_id', 'id');
    }

    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type_id');
    }
}
