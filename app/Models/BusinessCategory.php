<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BusinessCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['name', 'slug', 'meta_title', 'meta_description'];

    public function getName()
    {
        return $this->translate('name');
    }

    public function getSlug()
    {
        return $this->translate('slug');
    }

    public function getMetaDescription()
    {
        return $this->translate('meta_description');
    }

    public function getMetaTitle()
    {
        return $this->translate('meta_title');
    }
}
