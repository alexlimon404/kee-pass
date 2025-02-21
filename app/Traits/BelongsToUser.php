<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property User $user
 *
 * @method static Builder forUser(User|int $user)
 */
trait BelongsToUser
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser(Builder $query, $user): Builder
    {
        $user_id = is_object($user) ? $user->id : $user;

        return $query->where(compact('user_id'));
    }
}
