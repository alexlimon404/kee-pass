<?php

namespace App\Filament\Resources\FileResource\Pages;

use Filament\Actions;
use App\Filament\Resources\FileResource;
use Filament\Resources\Pages\ListRecords;

class ListFiles extends ListRecords
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->badge(),
        ];
    }
}
