<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $appointment_id
 * @property int $customer_id
 * @property int $business_id
 * @property string $price
 * @property string $addition_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Appointment|null $appointment
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint whereAdditionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCashPoint whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerCashPoint extends Model
{
    use HasFactory;
    protected $dates = ["addition_date"];

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'id', 'appointment_id');
    }
}
