<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use App\Filament\Resources\ArticleSectionResource\RelationManagers\ArticlesRelationManager;
use App\Filament\Resources\ArticleSectionResource\Pages\ListArticleSections;
use App\Filament\Resources\ArticleSectionResource\Pages\CreateArticleSection;
use App\Filament\Resources\ArticleSectionResource\Pages\EditArticleSection;
use App\Filament\Resources\ArticleSectionResource\Pages\ViewArticleSection;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Models\ArticleSection;
use Carbon\Carbon;
use Filament\Tables\Table;

class ArticleSectionResource extends BaseResource
{
    protected static ?int $navigationSort = 50;
    protected static string|\UnitEnum|null $navigationGroup = 'Settings';
    protected static ?string $model = ArticleSection::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getFormSchema($schema));
    }

    public static function table(Table $table): Table
    {
        return $table->columns(static::getTableColumns($table))
            ->recordActions([static::v(), static::e()]);
    }

    public static function getRelations(): array
    {
        return [
            ArticlesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticleSections::route('/'),
            'create' => CreateArticleSection::route('/create'),
            'edit' => EditArticleSection::route('/{record}/edit'),
            'view' => ViewArticleSection::route('/{record}'),
        ];
    }

    public static function getFormSchema(Schema $schema): array
    {
        return [
            Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    TextInput::make('name')
                        ->required(),
                ]),
        ];
    }

    public static function getTableColumns(Table $table): array
    {
        return [
            TextColumn::make('id')
                ->sortable(),
            TextColumn::make('created_at')
                ->toggleable(isToggledHiddenByDefault: true)
                ->formatStateUsing(fn (Carbon $state, ArticleSection $record) => __date($state)),
            TextColumn::make('name')
                ->searchable(),
        ];
    }

    public static function getInfoList(Schema $schema): array
    {
        return [];
    }
}
