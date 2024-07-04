<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $appointment_id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentPhoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppointmentPhoto extends Model
{
    use HasFactory;
}
