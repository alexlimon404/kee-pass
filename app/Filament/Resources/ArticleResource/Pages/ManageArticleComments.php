<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\ArticleResource;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ManageArticleComments extends ManageRelatedRecords
{
    protected static string $resource = ArticleResource::class;

    protected static string $relationship = 'comments';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public function getTitle(): string|Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "Manage {$recordTitle} Comments";
    }

    public function getBreadcrumb(): string
    {
        return 'Comments';
    }

    public static function getNavigationLabel(): string
    {
        return 'Manage Comments';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('comment')
                    ->required()
                    ->autosize()
                    ->label('Content'),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('comment')->limit(30),
            ])
            ->recordActions([
                ViewAction::make()->label(''),
                EditAction::make()->label(''),
                DeleteAction::make()->label(''),
            ])
            ->headerActions([
                CreateAction::make()->badge(),
            ]);
    }
}
