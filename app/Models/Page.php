<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $detail
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereDetail($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @property int $menu_id
 * @method static Builder|Page whereMenuId($value)
 * @property-read Menu|null $menu
 * @property string $image
 * @property string $description
 * @property string $meta_keys
 * @property string $meta_description
 * @property int $status
 * @method static Builder|Page whereDescription($value)
 * @method static Builder|Page whereImage($value)
 * @method static Builder|Page whereMetaDescription($value)
 * @method static Builder|Page whereMetaKeys($value)
 * @method static Builder|Page whereStatus($value)
 * @mixin Eloquent
 */
class Page extends Model
{
    use HasFactory;
}
