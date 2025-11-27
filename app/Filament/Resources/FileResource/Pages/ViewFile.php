<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource\Actions\ImportCSVFilamentAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\FileResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFile extends ViewRecord
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportCSVFilamentAction::make()->badge()->color('success'),
            EditAction::make()->badge(),
        ];
    }
}
