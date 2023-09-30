<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialCreatidCard extends Model
{
    use HasFactory;
    protected $fillable =[
      'is_default'
    ];

}
