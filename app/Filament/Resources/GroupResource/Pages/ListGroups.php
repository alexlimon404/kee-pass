<?php

namespace App\Filament\Resources\GroupResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\GroupResource;
use Filament\Resources\Pages\ListRecords;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->badge(),
        ];
    }
}
