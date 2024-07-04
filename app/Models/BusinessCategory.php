<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $icon
 * @property string $meta_title
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessCategory extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name', 'slug', 'meta_title', 'meta_description'];

    public function getName()
    {
        return $this->translate('name');
    }

    public function getMetaDescription()
    {
        return $this->translate('meta_description');
    }

    public function getMetaTitle()
    {
        return $this->translate('meta_title');
    }
}
