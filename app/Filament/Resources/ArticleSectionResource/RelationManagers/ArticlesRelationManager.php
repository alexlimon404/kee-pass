<?php

namespace App\Filament\Resources\ArticleSectionResource\RelationManagers;

use App\Models\Article;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use App\Filament\Resources\ArticleResource;
use Filament\Resources\RelationManagers\RelationManager;

class ArticlesRelationManager extends RelationManager
{
    protected static string $relationship = 'articles';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(ArticleResource::getTableColumns($table))
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('success'),
                Tables\Actions\Action::make('go')->url(fn (Article $record): string => ArticleResource::getUrl('view', [$record])),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(ArticleResource::getInfoList($infolist))->inlineLabel();
    }
}
