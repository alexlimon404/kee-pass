<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use App\Filament\Resources\ArticleCommentResource\Pages\ListArticleComments;
use App\Filament\Resources\ArticleCommentResource\Pages\CreateArticleComment;
use App\Filament\Resources\ArticleCommentResource\Pages\EditArticleComment;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Models\ArticleComment;
use Carbon\Carbon;
use Filament\Tables\Table;

class ArticleCommentResource extends BaseResource
{
    protected static ?int $navigationSort = 40;
    protected static string|\UnitEnum|null $navigationGroup = 'Settings';
    protected static ?string $model = ArticleComment::class;
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

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components(static::getInfoList($schema));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListArticleComments::route('/'),
            'create' => CreateArticleComment::route('/create'),
            'edit' => EditArticleComment::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(Schema $schema): array
    {
        return [
            Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    Textarea::make('comment')
                        ->autosize()
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
                ->formatStateUsing(fn (Carbon $state, ArticleComment $record) => __date($state)),
            TextColumn::make('article.title')->limit(30)
                ->color('warning')
                ->url(fn (ArticleComment $record) => ArticleResource::getUrl('view', [$record->article_id]))
                ->searchable(),
            TextColumn::make('comment')
                ->searchable(),
        ];
    }

    public static function getInfoList(Schema $schema): array
    {
        return [];
    }
}
