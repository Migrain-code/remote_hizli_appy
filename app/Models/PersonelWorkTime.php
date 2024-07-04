<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelWorkTime extends Model
{
    use HasFactory;
    protected $casts = [
        'start_date' => "date",
        'end_date' => "date",
        ];
    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
