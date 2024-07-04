<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness query()
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForBusiness whereValue($value)
 * @mixin \Eloquent
 */
class ForBusiness extends Model
{
    use HasFactory;
}
