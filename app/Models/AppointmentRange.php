<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentRange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentRange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentRange query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentRange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentRange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentRange whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentRange whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppointmentRange extends Model
{
    use HasFactory;
}
