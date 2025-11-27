<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Table;
use Illuminate\Support\Str;

// https://heroicons.com/
abstract class BaseResource extends Resource
{
    const cache_minutes_for_nav = 3;

    abstract public static function getFormSchema(Schema $schema): array;

    abstract public static function getTableColumns(Table $table): array;

    abstract public static function getInfoList(Schema $schema): array;

    public static function getNavigationLabel(): string
    {
        return Str::of(parent::getNavigationLabel())->lower()->ucfirst();
    }

    public static function getBreadcrumb(): string
    {
        return Str::of(parent::getBreadcrumb())->lower()->ucfirst();
    }

    public static function v(): ViewAction
    {
        return ViewAction::make()->iconButton()->iconSize(IconSize::Small)
            ->color('success');
    }

    public static function e(): EditAction
    {
        return EditAction::make()->iconButton()->iconSize(IconSize::Small);
    }

    public static function d(): DeleteAction
    {
        return DeleteAction::make()->iconButton()->iconSize(IconSize::Small);
    }
}
