<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use App\Models\Group;
use Filament\Tables\Table;
use App\Filament\Resources\GroupResource;
use Filament\Resources\RelationManagers\RelationManager;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns(GroupResource::getTableColumns($table))
            ->recordActions([
                ViewAction::make()->iconButton()->color('success'),
                Action::make('go')->url(fn (Group $record): string => GroupResource::getUrl('view', [$record])),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components(GroupResource::getInfoList($schema))->inlineLabel();
    }
}
