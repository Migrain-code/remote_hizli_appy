<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CostCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CostCategory extends Model
{
    use HasFactory;
}
