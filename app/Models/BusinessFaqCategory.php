<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BusinessFaqCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['name', 'slug'];
    public function faqs()
    {
        return $this->hasMany(BusinessFaq::class, 'category_id', 'id');
    }

    public function getName()
    {
        return $this->translate('name');
    }

    public function getSlug()
    {
        return $this->translate('slug');
    }
}
