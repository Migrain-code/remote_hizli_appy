<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property int $customer_id
 * @property string $payment_date
 * @property string $price
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessDep whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessDep extends Model
{
    use HasFactory;

    protected $casts = ["payment_date" => "date"];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
