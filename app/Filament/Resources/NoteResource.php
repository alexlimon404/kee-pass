<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoteResource\Pages;
use App\Models\Note;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class NoteResource extends BaseResource
{
    protected static ?int $navigationSort = 20;

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $model = Note::class;

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
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'view' => Pages\ViewNote::route('/{record}'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(Form $form): array
    {
        return [
            Forms\Components\Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    Forms\Components\Select::make('group_id')
                        ->relationship('group', 'breadcrumb')
                        ->preload()
                        ->searchable()
                        ->required(),
                    Forms\Components\TextInput::make('file_id')
                        ->nullable(),
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->default(auth()->user()->getAuthIdentifier())
                        ->required(),
                ]),
            Forms\Components\Section::make()->inlineLabel()
                ->columnSpan(1)
                ->columns(1)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required(),
                    Forms\Components\TextInput::make('username')
                        ->nullable(),
                    Forms\Components\TextInput::make('password')
                        ->nullable(),
                    Forms\Components\TextInput::make('url')
                        ->nullable(),
                ]),
            Forms\Components\Section::make()
                ->columnSpan(2)
                ->columns(1)
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->autosize()
                        ->nullable(),
                ]),
        ];
    }

    public static function getTableColumns(Table $table): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
            Tables\Columns\TextColumn::make('group.name')
                ->color('primary')
                ->url(fn (Note $record) => $record->group_id ? GroupResource::getUrl('view', [$record->group_id]) : null),
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('username'),
            Tables\Columns\TextColumn::make('url')
                ->searchable(),
            Tables\Columns\TextColumn::make('search')
                ->searchable()
                ->limit(1),
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
                        ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
                    Infolists\Components\TextEntry::make('group.name')
                        ->color('primary')
                        ->url(fn (Note $record) => $record->group_id ? GroupResource::getUrl('view', [$record->group_id]) : null),
                    Infolists\Components\TextEntry::make('file.name')
                        ->color('warning')
                        ->url(fn (Note $record) => $record->file_id ? FileResource::getUrl('view', [$record->file_id]) : null),
                    Infolists\Components\TextEntry::make('user.name')
                        ->color('warning')
                        ->url(fn (Note $record) => UserResource::getUrl('view', [$record->user_id])),
                ]),

            Infolists\Components\Section::make()->inlineLabel()
                ->columnSpan(1)
                ->schema([
                    Infolists\Components\TextEntry::make('title'),
                    Infolists\Components\TextEntry::make('username')->copyable(),
                    Infolists\Components\TextEntry::make('password')->copyable(),
                    Infolists\Components\TextEntry::make('url')->copyable(),
                    Infolists\Components\TextEntry::make('last_edit_at')
                        ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
                    Infolists\Components\TextEntry::make('created_at_from_export')
                        ->formatStateUsing(fn (Carbon $state, Note $record) => __date($state)),
                ]),
            Infolists\Components\Section::make()
                ->schema([
                    Infolists\Components\TextEntry::make('description')
                        ->prose(),
                    Infolists\Components\TextEntry::make('search'),
                ]),
        ];
    }
}
