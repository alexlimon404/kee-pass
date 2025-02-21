<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    private static bool $usesSearch = true;

    public static function bootHasSearch()
    {
        static::creating(function ($model) {
            static::usesSearch() && $model->fillSearch();
        });

        static::saving(function ($model) {
            static::usesSearch() && $model->fillSearch();
        });
    }

    abstract public function getSearch(): array;

    public function fillSearch(): self
    {
        $values = array_values($this->getSearch());
        $values = array_unique(array_filter($values));

        $search = mb_strtolower(implode('|', $values));

        return $this->forceFill(compact('search'));
    }

    public function updateSearch(): bool
    {
        return $this->fillSearch()->saveQuietly();
    }

    public function scopeSearch(Builder $query, string $search = null): Builder
    {
        $search && $query->where('search', 'like', "%{$search}%");

        return $query;
    }

    public function saveWithoutSearch(): bool
    {
        static::withoutSearch();

        $saved = $this->save();

        static::withSearch();

        return $saved;
    }

    public static function withoutSearch(): void
    {
        static::$usesSearch = false;
    }

    public static function withSearch(): void
    {
        static::$usesSearch = true;
    }

    public static function usesSearch(): bool
    {
        return static::$usesSearch;
    }
}
