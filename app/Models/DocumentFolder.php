<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFolder extends Model
{
    use HasFactory;

    public function files()
    {
        return $this->hasMany(DocumentFiles::class, 'folder_id', 'id');
    }
}
