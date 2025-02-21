<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id', 'name',
    ];
}
