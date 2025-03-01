<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'section_id',
        'title', 'description', 'content',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(ArticleSection::class, 'section_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }
}
