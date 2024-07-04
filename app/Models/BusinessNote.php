<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property string|null $title
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessNote whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessNote extends Model
{
    use HasFactory;
}
