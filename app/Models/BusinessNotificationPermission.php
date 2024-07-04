<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property int $is_sms
 * @property int $is_email
 * @property int $is_phone
 * @property int $is_notification
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereIsEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereIsNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereIsPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereIsSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNotificationPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessNotificationPermission extends Model
{
    use HasFactory;
}
