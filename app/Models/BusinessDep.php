<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDep extends Model
{
    use HasFactory;

    protected $dates = ["payment_date"];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
