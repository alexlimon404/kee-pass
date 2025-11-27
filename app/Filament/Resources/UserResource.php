<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\ViewUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;
use Carbon\Carbon;
use Filament\Tables\Table;

class UserResource extends BaseResource
{
    protected static ?int $navigationSort = 10;

    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user';

    public static function form(Schema $schema): Schema
    {
        return $schema->components(static::getFormSchema($schema))->inlineLabel();
    }

    public static function table(Table $table): Table
    {
        return $table->columns(static::getTableColumns($table))
            ->recordActions([
                static::v(), static::e(),
            ])->filtersFormMaxHeight('600px');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getFormSchema(Schema $schema): array
    {
        return [];
    }

    public static function getTableColumns(Table $table): array
    {
        return [
            TextColumn::make('id')
                ->sortable(),
            TextColumn::make('created_at')
                ->formatStateUsing(fn (Carbon $state, User $record) => __date($state)),
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('email')
                ->searchable(),
        ];
    }

    public static function getInfoList(Schema $schema): array
    {
        return [];
    }
}
