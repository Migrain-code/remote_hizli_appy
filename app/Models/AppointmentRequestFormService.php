<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentRequestFormService extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'business_service_id');
    }
}
