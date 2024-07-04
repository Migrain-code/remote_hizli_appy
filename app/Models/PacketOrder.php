<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketOrder extends Model
{
    use HasFactory;

    public function package()
    {
        return $this->hasOne(BussinessPackage::class, 'id', 'package_id');
    }

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
}
