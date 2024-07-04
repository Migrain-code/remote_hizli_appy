<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentRequestForm extends Model
{
    use HasFactory;
    protected $fillable = ["is_default"];
    public function questions()
    {
        return $this->hasMany(AppointmentRequestFormQuestion::class, 'appointment_request_form_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(AppointmentRequestFormService::class, 'appointment_request_form_id', 'id');
    }

}
