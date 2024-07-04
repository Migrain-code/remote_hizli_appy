<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property int $appointment_id
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RemainingPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RemainingPayment extends Model
{
    use HasFactory;
}
