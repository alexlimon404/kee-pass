<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use Filament\Tables;
use App\Models\Note;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use App\Filament\Resources\NoteResource;
use Filament\Resources\RelationManagers\RelationManager;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(NoteResource::getTableColumns($table))
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('success'),
                Tables\Actions\Action::make('go')->url(fn (Note $record): string => NoteResource::getUrl('view', [$record])),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(NoteResource::getInfoList($infolist))->inlineLabel();
    }
}
