<?php

namespace App\Models;

use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * @property int id
 * @property int parent_id
 * @property string name
 * @property string breadcrumb
 *
 * Relations
 * @property Group parent
 **/
class Group extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id', 'parent_id', 'name', 'breadcrumb',
    ];

    public static function booted(): void
    {
        static::creating(function (Group $model) {
            $model->fillBreadcrumb();
        });

        static::saving(function (Group $model) {
            $model->fillBreadcrumb();
        });
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Group::class, 'parent_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function fillBreadcrumb(): void
    {
        $parent = $this->parent;
        $breadcrumbs = [];
        while ($parent) {
            array_unshift($breadcrumbs, $parent->name);
            $parent = $parent->parent_id ? $parent->parent : null;
        }

        $breadcrumbs[] = $this->name;

        $this->fill([
            'breadcrumb' => implode('/', $breadcrumbs),
        ]);
    }
}
