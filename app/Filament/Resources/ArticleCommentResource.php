<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleCommentResource\Pages;
use App\Models\ArticleComment;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleCommentResource extends BaseResource
{
    protected static ?int $navigationSort = 30;
    protected static ?string $navigationGroup = 'Articles';
    protected static ?string $model = ArticleComment::class;
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(static::getInfoList($infolist));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticleComments::route('/'),
            'create' => Pages\CreateArticleComment::route('/create'),
            'edit' => Pages\EditArticleComment::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(Form $form): array
    {
        return [
            Forms\Components\Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('comment')
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
                ->formatStateUsing(fn (Carbon $state, ArticleComment $record) => __date($state)),
            Tables\Columns\TextColumn::make('article.title')->limit(30)
                ->color('warning')
                ->url(fn (ArticleComment $record) => ArticleResource::getUrl('view', [$record->article_id]))
                ->searchable(),
            Tables\Columns\TextColumn::make('comment')
                ->searchable(),
        ];
    }

    public static function getInfoList(Infolist $infolist): array
    {
        return [];
    }
}
