<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Models\Group;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class GroupResource extends BaseResource
{
    protected static ?int $navigationSort = 30;

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $model = Group::class;

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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildrenRelationManager::make(),
            RelationManagers\NotesRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'view' => Pages\ViewGroup::route('/{record}'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(Form $form): array
    {
        return [
            Forms\Components\Section::make()->inlineLabel()
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->required()
                        ->default(auth()->user()->getAuthIdentifier()),
                    Forms\Components\Select::make('parent_id')
                        ->relationship('parent', 'name')
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('breadcrumb')
                        ->nullable()->readOnly(),

                ]),
        ];
    }

    public static function getTableColumns(Table $table): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->toggleable(isToggledHiddenByDefault: true)
                ->formatStateUsing(fn (Carbon $state, Group $record) => __date($state)),
            Tables\Columns\TextColumn::make('breadcrumb')
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('parent.name')
                ->color('primary')
                ->toggleable(isToggledHiddenByDefault: true)
                ->url(fn (Group $record) => $record->group_id ? GroupResource::getUrl('view', [$record->group_id]) : null),
        ];
    }

    public static function getInfoList(Infolist $infolist): array
    {
        return [
            Infolists\Components\Section::make()->inlineLabel()
                ->columnSpan(1)
                ->schema([
                    Infolists\Components\TextEntry::make('id'),
                    Infolists\Components\TextEntry::make('created_at')
                        ->formatStateUsing(fn (Carbon $state, Group $record) => __date($state)),
                    Infolists\Components\TextEntry::make('user.name')
                        ->color('primary')
                        ->url(fn (Group $record) => UserResource::getUrl('view', [$record->user_id])),
                    Infolists\Components\TextEntry::make('parent.name')
                        ->color('primary')
                        ->url(fn (Group $record) => $record->parent_id ? GroupResource::getUrl('view', [$record->parent_id]) : null),
                    Infolists\Components\TextEntry::make('name'),
                    Infolists\Components\TextEntry::make('breadcrumb'),
                ]),
        ];
    }
}
