<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconSize;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables;

// https://heroicons.com/
abstract class BaseResource extends Resource
{
    const cache_minutes_for_nav = 3;

    abstract public static function getFormSchema(Form $form): array;

    abstract public static function getTableColumns(Table $table): array;

    abstract public static function getInfoList(Infolist $infolist): array;

    public static function getNavigationLabel(): string
    {
        return Str::of(parent::getNavigationLabel())->lower()->ucfirst();
    }

    public static function getBreadcrumb(): string
    {
        return Str::of(parent::getBreadcrumb())->lower()->ucfirst();
    }

    public static function v(): Tables\Actions\ViewAction
    {
        return Tables\Actions\ViewAction::make()->iconButton()->iconSize(IconSize::Small)
            ->color('success');
    }

    public static function e(): Tables\Actions\EditAction
    {
        return Tables\Actions\EditAction::make()->iconButton()->iconSize(IconSize::Small);
    }

    public static function d(): Tables\Actions\DeleteAction
    {
        return Tables\Actions\DeleteAction::make()->iconButton()->iconSize(IconSize::Small);
    }
}
