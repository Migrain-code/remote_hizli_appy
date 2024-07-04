<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $action
 * @property string $phone
 * @property string $code
 * @property string $expire_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation query()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsConfirmation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SmsConfirmation extends Model
{
    use HasFactory;
}
