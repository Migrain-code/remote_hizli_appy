<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelRoom extends Model
{
    use HasFactory;

    public function room()
    {
        return $this->hasOne(BusinessRoom::class, 'id', 'room_id');
    }
}
