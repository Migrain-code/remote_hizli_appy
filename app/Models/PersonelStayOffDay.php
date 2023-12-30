<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelStayOffDay extends Model
{
    use HasFactory;

    protected $dates = ["start_time", 'end_time'];

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
