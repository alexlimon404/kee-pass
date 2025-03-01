<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class ArticleResource extends BaseResource
{
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationGroup = 'Articles';
    protected static ?string $model = Article::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema($form));
    }

    public static function table(Table $table): Table
    {
        return $table->columns(static::getTableColumns($table))
            ->actions([static::v(), static::e()]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(static::getInfoList($infolist));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
            'comments' => Pages\ManageArticleComments::route('/{record}/comments'),
        ];
    }

    public static function getFormSchema(Form $form): array
    {
        return [
            Forms\Components\Section::make()->inlineLabel()
                ->columnSpan(2)
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('section_id')
                        ->relationship('section', 'name')
                        ->preload()
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('title')
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->autosize()
                        ->nullable(),
                    Forms\Components\RichEditor::make('content')
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
                ->formatStateUsing(fn (Carbon $state, Article $record) => __date($state)),
            Tables\Columns\TextColumn::make('section.name')
                ->color('primary')
                ->url(fn (Article $record) => ArticleSectionResource::getUrl('view', [$record->section_id])),
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('description')->limit(30),
        ];
    }

    public static function getInfoList(Infolist $infolist): array
    {
        return [
            Infolists\Components\Section::make()->inlineLabel()
                ->columnSpan(2)
                ->schema([
                    Infolists\Components\TextEntry::make('id'),
                    Infolists\Components\TextEntry::make('created_at')
                        ->formatStateUsing(fn (Carbon $state, Article $record) => __date($state)),
                    Infolists\Components\TextEntry::make('section.name')
                        ->color('primary')
                        ->url(fn (Article $record) => ArticleSectionResource::getUrl('view', [$record->section_id])),
                    Infolists\Components\TextEntry::make('title'),
                    Infolists\Components\TextEntry::make('description'),
                ]),
            Infolists\Components\Section::make()
                ->columnSpan(2)
                ->schema([
                    Infolists\Components\TextEntry::make('content')
                        ->prose(),
                ]),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewArticle::class,
            Pages\EditArticle::class,
            Pages\ManageArticleComments::class,
        ]);
    }
}
