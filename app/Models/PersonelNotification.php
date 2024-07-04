<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property int $personel_id
 * @property string $title
 * @property string $message
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonelNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PersonelNotification extends Model
{
    use HasFactory;
}
