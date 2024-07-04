<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCloseDate extends Model
{
    use HasFactory;

    protected $casts = ["start_time" => "date", "end_time" => "date"];
}
