<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 *
 *
 * @property int $id
 * @property int $category_id
 * @property string $question
 * @property string $answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessFaq whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessFaq extends Model
{
    use HasFactory, HasTranslations;

    protected $translatable = ['question', 'answer'];

    public function getAnswer()
    {
        return $this->translate('answer');
    }

    public function getQuestion()
    {
        return $this->translate('question');

    }
}
