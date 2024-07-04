<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $business_id
 * @property int $cost_category_id
 * @property int $personel_id
 * @property int $payment_type_id
 * @property string $price
 * @property string $operation_date
 * @property string|null $description
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CostCategory|null $category
 * @property-read \App\Models\Personel|null $personel
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereCostCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereOperationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessCost whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BusinessCost extends Model
{
    use HasFactory;
    protected $casts = ['operation_date' => "date"];
    const PAYMENT_TYPES = [
        0 => ["id" => 0, "name" => "Nakit"],
        1 => ["id" => 1, "name" => "Banka / Kredi Kartı"],
        2 => ["id" => 2, "name" => "EFT / Havale"],
        3 => ["id" => 3, "name" => "Diğer"],
    ];

    public function type($type = "id")
    {
        return self::PAYMENT_TYPES[$this->payment_type_id][$type];
    }
    public function category()
    {
        return $this->hasOne(CostCategory::class, 'id', 'cost_category_id');
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
