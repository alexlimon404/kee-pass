<?php

namespace App\Filament\Resources\ArticleSectionResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use App\Models\Article;
use Filament\Tables\Table;
use App\Filament\Resources\ArticleResource;
use Filament\Resources\RelationManagers\RelationManager;

class ArticlesRelationManager extends RelationManager
{
    protected static string $relationship = 'articles';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(ArticleResource::getTableColumns($table))
            ->recordActions([
                ViewAction::make()->iconButton()->color('success'),
                Action::make('go')->url(fn (Article $record): string => ArticleResource::getUrl('view', [$record])),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components(ArticleResource::getInfoList($schema))->inlineLabel();
    }
}
