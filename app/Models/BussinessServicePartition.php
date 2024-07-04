<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $service_id
 * @property string $name
 * @property int $service_category
 * @property int $service_sub_category
 * @property int|null $price
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition query()
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereServiceCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereServiceSubCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BussinessServicePartition whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BussinessServicePartition extends Model
{
    use HasFactory;
}
