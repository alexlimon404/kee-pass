<?php

namespace App\Filament\Resources\NoteResource\Pages;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\NoteResource;
use Filament\Resources\Pages\ViewRecord;

class ViewNote extends ViewRecord
{
    protected static string $resource = NoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->badge(),
            DeleteAction::make()->badge(),
        ];
    }
}
