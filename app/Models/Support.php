<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property string $subject
 * @property string $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Support newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Support newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Support query()
 * @method static \Illuminate\Database\Eloquent\Builder|Support whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Support whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Support whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Support whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Support whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Support whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Support whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Support extends Model
{
    use HasFactory;
}
