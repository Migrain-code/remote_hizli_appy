<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
