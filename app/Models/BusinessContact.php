<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $fullName
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property string $ip
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessContact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessContact extends Model
{
    use HasFactory;
}
