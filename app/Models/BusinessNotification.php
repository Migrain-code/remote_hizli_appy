<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property string $title
 * @property string $message
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessNotification extends Model
{
    use HasFactory;
}
