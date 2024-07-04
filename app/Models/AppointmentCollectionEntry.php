<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $appointment_id
 * @property int $payment_type_id
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppointmentCollectionEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppointmentCollectionEntry extends Model
{
    use HasFactory;

    const PAYMENT_TYPES = [
        0 => ["id" => 0, "name" => "Nakit"],
        1 => ["id" => 1, "name" => "Banka / Kredi Kartı"],
        2 => ["id" => 2, "name" => "EFT / Havale"],
        3 => ["id" => 3, "name" => "Diğer"],
    ];

    public function type($type)
    {
        return self::PAYMENT_TYPES[$this->payment_type_id][$type] ?? null;
    }
}
