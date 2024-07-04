<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property string $way
 * @property string $byte
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery whereByte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessGallery whereWay($value)
 * @mixin \Eloquent
 */
class BusinessGallery extends Model
{
    use HasFactory;
}
