<?php

namespace App\Filament\Resources\NoteResource\Pages;

use Filament\Actions;
use App\Filament\Resources\NoteResource;
use Filament\Resources\Pages\EditRecord;

class EditNote extends EditRecord
{
    protected static string $resource = NoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->badge()->color('success'),
        ];
    }
}
