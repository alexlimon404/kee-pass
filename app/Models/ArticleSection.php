<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleSection extends Model
{
    protected $fillable = [
        'name', 'sort',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'section_id');
    }
}
