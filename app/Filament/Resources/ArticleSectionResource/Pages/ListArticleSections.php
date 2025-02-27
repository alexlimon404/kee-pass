<?php

namespace App\Filament\Resources\ArticleSectionResource\Pages;

use App\Filament\Resources\ArticleSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticleSections extends ListRecords
{
    protected static string $resource = ArticleSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->badge(),
        ];
    }
}
