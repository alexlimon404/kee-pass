<?php

namespace App\Filament\Resources;

use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Schemas\Schema;
use App\Filament\Resources\ArticleResource\Pages\ListArticles;
use App\Filament\Resources\ArticleResource\Pages\CreateArticle;
use App\Filament\Resources\ArticleResource\Pages\ViewArticle;
use App\Filament\Resources\ArticleResource\Pages\EditArticle;
use App\Filament\Resources\ArticleResource\Pages\ManageArticleComments;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\TextEntry;
use App\Models\Article;
use Carbon\Carbon;
use Filament\Resources\Pages\Page;
use Filament\Tables\Table;

class ArticleResource extends BaseResource
{
    protected static ?int $navigationSort = 20;
    protected static ?string $model = Article::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?\Filament\Pages\Enums\SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getFormSchema($schema));
    }

    public static function table(Table $table): Table
    {
        return $table->columns(static::getTableColumns($table))
            ->recordActions([static::v(), static::e()]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components(static::getInfoList($schema));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticles::route('/'),
            'create' => CreateArticle::route('/create'),
            'view' => ViewArticle::route('/{record}'),
            'edit' => EditArticle::route('/{record}/edit'),
            'comments' => ManageArticleComments::route('/{record}/comments'),
        ];
    }

    public static function getFormSchema(Schema $schema): array
    {
        return [
            Section::make()
                ->inlineLabel()
                ->columnSpan(2)
                ->schema([
                    Select::make('section_id')
                        ->relationship('section', 'name')
                        ->preload()
                        ->searchable()
                        ->required(),
                    TextInput::make('title')
                        ->required(),
                    Textarea::make('description')
                        ->autosize()
                        ->nullable(),
                ]),
            Section::make()
                ->columnSpan(2)
                ->schema([
                    RichEditor::make('content')
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
                ->formatStateUsing(fn (Carbon $state, Article $record) => __date($state)),
            TextColumn::make('section.name')
                ->color('primary')
                ->url(fn (Article $record) => ArticleSectionResource::getUrl('view', [$record->section_id])),
            TextColumn::make('title')->limit(40)->searchable(),
            TextColumn::make('description')->limit(30)->searchable(),
            TextColumn::make('content')
                ->toggleable(isToggledHiddenByDefault: true)
                ->limit(30)
                ->searchable(),
        ];
    }

    public static function getInfoList(Schema $schema): array
    {
        return [
            Section::make()->inlineLabel()
                ->columnSpan(2)
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('created_at')
                        ->formatStateUsing(fn (Carbon $state, Article $record) => __date($state)),
                    TextEntry::make('section.name')
                        ->color('primary')
                        ->url(fn (Article $record) => ArticleSectionResource::getUrl('view', [$record->section_id])),
                    TextEntry::make('title'),
                    TextEntry::make('description'),
                ]),
            Section::make()
                ->columnSpan(2)
                ->schema([
                    TextEntry::make('content'),
                ]),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            ViewArticle::class,
            EditArticle::class,
            ManageArticleComments::class,
        ]);
    }
}
