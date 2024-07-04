<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $status 0 => pasif, 1=> aktif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList query()
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MessageList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MessageList extends Model
{
    use HasFactory;
}
