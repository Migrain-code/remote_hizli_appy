<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ServiceSubCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['name', 'slug'];
    public function getName()
    {
        return $this->translate('name');
    }
    public function category()
    {
        return $this->hasOne(ServiceCategory::class,'id', 'category_id');
    }
}
