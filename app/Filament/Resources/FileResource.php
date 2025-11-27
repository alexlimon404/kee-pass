<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use App\Filament\Resources\FileResource\Pages\ListFiles;
use App\Filament\Resources\FileResource\Pages\CreateFile;
use App\Filament\Resources\FileResource\Pages\ViewFile;
use App\Filament\Resources\FileResource\Pages\EditFile;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Models\File;
use Carbon\Carbon;
use Filament\Tables\Table;

class FileResource extends BaseResource
{
    protected static ?int $navigationSort = 30;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $model = File::class;

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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFiles::route('/'),
            'create' => CreateFile::route('/create'),
            'view' => ViewFile::route('/{record}'),
            'edit' => EditFile::route('/{record}/edit'),
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
                    TextInput::make('name')
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
                ->formatStateUsing(fn (Carbon $state, File $record) => __date($state)),
            TextColumn::make('name'),
        ];
    }

    public static function getInfoList(Schema $schema): array
    {
        // TODO: Implement getInfoList() method.
    }
}
