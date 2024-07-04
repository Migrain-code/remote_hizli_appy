<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecommendedLink whereUrl($value)
 * @mixin \Eloquent
 */
class RecommendedLink extends Model
{
    use HasFactory;
}
