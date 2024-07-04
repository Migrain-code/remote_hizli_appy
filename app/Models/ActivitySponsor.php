<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $activity_id
 * @property string|null $link
 * @property string|null $name
 * @property string|null $text
 * @property string $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivitySponsor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ActivitySponsor extends Model
{
    use HasFactory;
}
