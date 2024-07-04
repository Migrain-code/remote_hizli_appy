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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $type 0 => randevu 1 => işletme
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessCustomerNote> $notes
 * @property-read int|null $notes_count
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessCustomer extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->hasOne(Customer::class,'id', 'customer_id');
    }

    public function notes()
    {
        return $this->hasMany(BusinessCustomerNote::class,'business_customer_id', 'id');

    }

}
