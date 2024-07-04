<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property string|null $sub_title
 * @property string|null $sub_description
 * @property string|null $detail
 * @property string|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereSubDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppPropartie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppPropartie extends Model
{
    use HasFactory;
}
