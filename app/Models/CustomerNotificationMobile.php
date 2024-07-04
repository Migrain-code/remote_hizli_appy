<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $customer_id
 * @property string|null $content
 * @property string $status
 * @property int $notification_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerNotificationMobile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerNotificationMobile extends Model
{
    use HasFactory;
}
