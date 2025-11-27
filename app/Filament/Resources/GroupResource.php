<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use App\Filament\Resources\GroupResource\RelationManagers\ChildrenRelationManager;
use App\Filament\Resources\GroupResource\RelationManagers\NotesRelationManager;
use App\Filament\Resources\GroupResource\Pages\ListGroups;
use App\Filament\Resources\GroupResource\Pages\CreateGroup;
use App\Filament\Resources\GroupResource\Pages\ViewGroup;
use App\Filament\Resources\GroupResource\Pages\EditGroup;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\TextEntry;
use App\Models\Group;
use Carbon\Carbon;
use Filament\Tables\Table;

class GroupResource extends BaseResource
{
    protected static ?int $navigationSort = 20;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $model = Group::class;

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

    public static function getRelations(): array
    {
        return [
            ChildrenRelationManager::make(),
            NotesRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'create' => CreateGroup::route('/create'),
            'view' => ViewGroup::route('/{record}'),
            'edit' => EditGroup::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(Schema $schema): array
    {
        return [
            Section::make()->inlineLabel()
                ->columns(1)
                ->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->required()
                        ->default(auth()->user()->getAuthIdentifier()),
                    Select::make('parent_id')
                        ->relationship('parent', 'name')
                        ->nullable(),
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('breadcrumb')
                        ->nullable()->readOnly(),
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
                ->formatStateUsing(fn (Carbon $state, Group $record) => __date($state)),
            TextColumn::make('breadcrumb')
                ->searchable(),
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('parent.name')
                ->color('primary')
                ->toggleable(isToggledHiddenByDefault: true)
                ->url(fn (Group $record) => $record->parent_id ? GroupResource::getUrl('view', [$record->parent_id]) : null),
            TextColumn::make('children_count')
                ->sortable(),
        ];
    }

    public static function getInfoList(Schema $schema): array
    {
        return [
            Section::make()->inlineLabel()
                ->columnSpan(1)
                ->schema([
                    TextEntry::make('id'),
                    TextEntry::make('created_at')
                        ->formatStateUsing(fn (Carbon $state, Group $record) => __date($state)),
                    TextEntry::make('user.name')
                        ->color('primary')
                        ->url(fn (Group $record) => UserResource::getUrl('view', [$record->user_id])),
                    TextEntry::make('parent.name')
                        ->color('primary')
                        ->url(fn (Group $record) => $record->parent_id ? GroupResource::getUrl('view', [$record->parent_id]) : null),
                    TextEntry::make('name'),
                    TextEntry::make('breadcrumb'),
                    TextEntry::make('children_count'),
                ]),
        ];
    }
}
