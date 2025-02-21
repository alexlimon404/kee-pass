<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use App\Models\Group;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use App\Filament\Resources\GroupResource;
use Filament\Resources\RelationManagers\RelationManager;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    public function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(GroupResource::getTableColumns($table))
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton()->color('success'),
                Tables\Actions\Action::make('go')->url(fn (Group $record): string => GroupResource::getUrl('view', [$record])),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema(GroupResource::getInfoList($infolist))->inlineLabel();
    }
}
