<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BusinessBlog extends Model
{
    use HasFactory, HasTranslations;
    protected $translatable = ['titles', 'descriptions', 'meta_titles', 'slug'];

    public function getTitle()
    {
        return $this->translate('titles');
    }

    public function getSlug()
    {
        return $this->translate('slug');
    }

    public function getDescription()
    {
        return $this->translate('descriptions');
    }
    public function getMetaTitle()
    {
        return $this->translate('meta_titles');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
