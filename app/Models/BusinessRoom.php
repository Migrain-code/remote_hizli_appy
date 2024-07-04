<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRoom extends Model
{
    use HasFactory;

    public function personels()
    {
        return $this->hasMany(PersonelRoom::class, 'room_id', 'id');
    }
}
