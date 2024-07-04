<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property int $customer_id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerGallery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerGallery extends Model
{
    use HasFactory;
}
