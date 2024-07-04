<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_customer_id
 * @property string|null $title
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote whereBusinessCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCustomerNote whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessCustomerNote extends Model
{
    use HasFactory;
}
