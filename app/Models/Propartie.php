<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $icon
 * @property string|null $slug
 * @property string $name
 * @property string|null $description
 * @property string|null $detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property string $sub_title
 * @property string $images
 * @property string $list
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Propartie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Propartie extends Model
{
    use HasFactory;
}
