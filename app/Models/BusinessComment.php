<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property int|null $customer_id
 * @property string $content
 * @property int $point
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessComment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessComment extends Model
{
    use HasFactory;

    public function business()
    {
        return $this->hasOne(Business::class, 'id', 'business_id');
    }
}
