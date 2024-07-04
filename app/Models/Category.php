<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['name', 'slug', 'meta_description', 'meta_title'];
    public function blogs()
    {
        return $this->hasMany(BusinessBlog::class, 'category_id', 'id');
    }

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
