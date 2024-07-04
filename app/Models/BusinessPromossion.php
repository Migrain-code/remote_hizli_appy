<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $business_id
 * @property int $cash
 * @property int $credit_cart
 * @property int $eft
 * @property int $use_limit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $birthday_discount
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereBirthdayDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereCreditCart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereEft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessPromossion whereUseLimit($value)
 * @mixin \Eloquent
 */
class BusinessPromossion extends Model
{
    use HasFactory;

    const PAYMENT_TYPES = [
        0 => [
            "id" => 0,
            "name" => "Parapuan Kullanımı (Nakit)",
            "form_name" => "cash",
        ],
        1 => [
            "id" => 1,
            "name" => "Parapuan Kullanımı (Kredi Kartı)",
            "form_name" => "creditCard",
        ],
        2 => [
            "id" => 2,
            "name" => "Parapuan Kullanımı (EFT / Havale)",
            "form_name" => "eft",
        ],
        3 => [
            "id" => 3,
            "name" => "Parapuan Kullanımı Limiti",
            "form_name" => "limit",
        ],
        4 => [
            "id" => 4,
            "name" => "Doğum Günü İndirimi",
            "form_name" => "birthday",
        ],
    ];

    public function type($type)
    {
        return self::PAYMENT_TYPES[$this->payment_type][$type] ?? null;
    }
}
