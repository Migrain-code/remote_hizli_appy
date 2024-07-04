<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int|null $appointment_id
 * @property int $business_id
 * @property int $customer_id
 * @property string $payment_date
 * @property string $price
 * @property int $status
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentReceivable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppointmentReceivable extends Model
{
    use HasFactory;
    protected $casts = ['payment_date' => 'date'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
