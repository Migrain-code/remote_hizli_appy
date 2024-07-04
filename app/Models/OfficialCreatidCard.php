<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $official_id
 * @property string $number
 * @property string|null $cvc
 * @property string $month
 * @property string $year
 * @property string $name_on_the_card
 * @property int $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereCvc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereNameOnTheCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereOfficialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialCreatidCard whereYear($value)
 * @mixin \Eloquent
 */
class OfficialCreatidCard extends Model
{
    use HasFactory;
    protected $fillable =[
      'is_default'
    ];

}
