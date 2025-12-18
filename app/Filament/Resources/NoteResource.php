<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use App\Filament\Resources\NoteResource\Pages\ListNotes;
use App\Filament\Resources\NoteResource\Pages\CreateNote;
use App\Filament\Resources\NoteResource\Pages\ViewNote;
use App\Filament\Resources\NoteResource\Pages\EditNote;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Filters\SelectFilter;
use App\Models\File;
use App\Models\Note;
use Carbon\Carbon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NoteResource extends BaseResource
{
    protected static ?int $navigationSort = 10;

    protected static ?string $model = Note::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getFormSchema($schema));
    }

    public static function table(Table $table): Table
    {
        return $table->columns(static::getTableColumns($table))
            ->recordActions([static::v(), static::e()])
            ->filters(static::getTableFilters($table));
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components(static::getInfoList($schema));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotes::route('/'),
            'create' => CreateNote::route('/create'),
            'view' => ViewNote::route('/{record}'),
            'edit' => EditNote::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(Schema $schema): array
    {
        return [
            Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    Select::make('group_id')
                        ->relationship('group', 'breadcrumb')
                        ->preload()
                        ->searchable()
                        ->required(),
                    TextInput::make('file_id')
                        ->nullable(),
                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->default(auth()->user()->getAuthIdentifier())
                        ->required(),
                ]),
            Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    TextInput::make('title')
                        ->required(),
                    TextInput::make('username')
                        ->nullable(),
                    TextInput::make('password')
                        ->nullable(),
                    TextInput::make('url')
                        ->nullable(),
                ]),
            Section::make()
                ->columnSpan(2)
                ->columns(1)
                ->schema([
                    Textarea::make('description')
                        ->autosize()
                        ->nullable(),
                ]),
        ];
    }

    public static function getTableColumns(Table $table): array
    {
        return [
            TextColumn::make('id')
                ->sortable(),
            TextColumn::make('created_at')
                ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
            TextColumn::make('file.name')
                ->toggleable(isToggledHiddenByDefault: true)
                ->color('primary')
                ->url(fn (Note $record) => $record->file_id ? FileResource::getUrl('view', [$record->file_id]) : null),
            TextColumn::make('group.name')
                ->color('primary')
                ->url(fn (Note $record) => $record->group_id ? GroupResource::getUrl('view', [$record->group_id]) : null),
            TextColumn::make('title'),
            TextColumn::make('username'),
            TextColumn::make('url')
                ->searchable(),
            TextColumn::make('search')
                ->searchable()
                ->limit(1),
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
                        ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
                    TextEntry::make('group.name')
                        ->color('primary')
                        ->url(fn (Note $record) => $record->group_id ? GroupResource::getUrl('view', [$record->group_id]) : null),
                    TextEntry::make('file.name')
                        ->color('warning')
                        ->url(fn (Note $record) => $record->file_id ? FileResource::getUrl('view', [$record->file_id]) : null),
                    TextEntry::make('user.name')
                        ->color('warning')
                        ->url(fn (Note $record) => UserResource::getUrl('view', [$record->user_id])),
                ]),

            Section::make()->inlineLabel()
                ->columnSpan(1)
                ->schema([
                    TextEntry::make('title'),
                    TextEntry::make('username')->copyable(),
                    TextEntry::make('password')->copyable(),
                    TextEntry::make('url')->copyable(),
                    TextEntry::make('last_edit_at')
                        ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
                    TextEntry::make('created_at_from_export')
                        ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
                ]),
            Section::make()
                ->schema([
                    TextEntry::make('description'),
                    TextEntry::make('search'),
                ]),
        ];
    }

    public static function getTableFilters(Table $table): array
    {
        return [
            SelectFilter::make('File')
                ->options(File::get()->pluck('name', 'id'))
                ->query(function (Builder $query, array $data) {
                    if ($data['value']) {
                        return $query->where('file_id', $data['value']);
                    }
                    return $query;
                }),
        ];
    }
}
