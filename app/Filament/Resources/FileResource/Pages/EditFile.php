<?php

namespace App\Filament\Resources\FileResource\Pages;

use Filament\Actions;
use App\Filament\Resources\FileResource;
use Filament\Resources\Pages\EditRecord;

class EditFile extends EditRecord
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->badge()->color('success'),
        ];
    }
}
