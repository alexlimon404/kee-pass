<?php

namespace App\Filament\Resources\FileResource\Pages;

use Filament\Actions;
use App\Filament\Resources\FileResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFile extends ViewRecord
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FileResource\Actions\ImportCSVFilamentAction::make()->badge()->color('success'),
            Actions\EditAction::make()->badge(),
        ];
    }
}
