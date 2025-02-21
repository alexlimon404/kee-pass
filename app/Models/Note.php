<?php

namespace App\Models;

use App\Traits\HasSearch;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use BelongsToUser, HasSearch;

    protected $fillable = [
        'group_id', 'user_id', 'file_id',
        'title', 'username', 'password', 'url', 'description',
        'last_edit_at', 'created_at_from_export',
        'search',
    ];

    protected $casts = [
        'last_edit_at' => 'datetime',
        'created_at_from_export' => 'datetime',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function getSearch(): array
    {
        return [
            $this->id,
            $this->title,
            $this->username,
            $this->url,
        ];
    }
}
