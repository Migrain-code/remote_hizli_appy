<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCashPoint extends Model
{
    use HasFactory;
    protected $dates = ["addition_date"];
}
