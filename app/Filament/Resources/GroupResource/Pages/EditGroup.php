<?php

namespace App\Filament\Resources\GroupResource\Pages;

use Filament\Actions\ViewAction;
use App\Filament\Resources\GroupResource;
use Filament\Resources\Pages\EditRecord;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->badge()->color('success'),
        ];
    }
}
