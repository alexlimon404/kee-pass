<?php

namespace App\Filament\Resources\ArticleSectionResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ArticleSectionResource;
use Filament\Resources\Pages\ListRecords;

class ListArticleSections extends ListRecords
{
    protected static string $resource = ArticleSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->badge(),
        ];
    }
}
