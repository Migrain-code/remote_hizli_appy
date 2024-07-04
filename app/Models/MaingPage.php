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
 * @property string|null $value
 * @property string $link
 * @property string $button_text
 * @property int $status
 * @property int $type
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereButtonText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MaingPage whereValue($value)
 * @mixin \Eloquent
 */
class MaingPage extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['name', 'value', 'button_text'];

    public function getName()
    {
        return $this->translate('name');
    }

    public function getValue()
    {
        return $this->translate('value');
    }

    public function getButtonText()
    {
        return $this->translate('button_text');
    }


}
