<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 *
 *
 * @property int $id
 * @property string|null $description
 * @property string|null $title
 * @property string $image
 * @property string|null $logo
 * @property string|null $link
 * @property int $status
 * @property int $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ads newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ads newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ads query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ads whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ads extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['title', 'description'];
    public function getTitle()
    {
        return $this->translate('title');
    }

    public function getDescription()
    {
        return $this->translate('description');
    }
}
