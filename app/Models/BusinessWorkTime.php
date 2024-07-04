<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property string|null $start_time
 * @property string|null $end_time
 * @property int $que
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereQue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessWorkTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessWorkTime extends Model
{
    use HasFactory;
}
