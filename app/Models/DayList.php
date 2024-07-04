<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DayList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DayList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DayList query()
 * @method static \Illuminate\Database\Eloquent\Builder|DayList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DayList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DayList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DayList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DayList extends Model
{
    use HasFactory;
}
