<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleSectionResource\Pages;
use App\Filament\Resources\ArticleSectionResource\RelationManagers;
use App\Models\ArticleSection;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class ArticleSectionResource extends BaseResource
{
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationGroup = 'Articles';
    protected static ?string $model = ArticleSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema($form));
    }

    public static function table(Table $table): Table
    {
        return $table->columns(static::getTableColumns($table))
            ->actions([static::v(), static::e()]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ArticlesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticleSections::route('/'),
            'create' => Pages\CreateArticleSection::route('/create'),
            'edit' => Pages\EditArticleSection::route('/{record}/edit'),
            'view' => Pages\ViewArticleSection::route('/{record}'),
        ];
    }

    public static function getFormSchema(Form $form): array
    {
        return [
            Forms\Components\Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                ]),
        ];
    }

    public static function getTableColumns(Table $table): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->formatStateUsing(fn (Carbon $state, ArticleSection $record) => __date($state)),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
        ];
    }

    public static function getInfoList(Infolist $infolist): array
    {
        return [];
    }
}
