<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use App\Models\Note;
use Filament\Tables\Table;
use App\Filament\Resources\NoteResource;
use Filament\Resources\RelationManagers\RelationManager;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(NoteResource::getTableColumns($table))
            ->recordActions([
                ViewAction::make()->iconButton()->color('success'),
                Action::make('go')->url(fn (Note $record): string => NoteResource::getUrl('view', [$record])),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components(NoteResource::getInfoList($schema))->inlineLabel();
    }
}
