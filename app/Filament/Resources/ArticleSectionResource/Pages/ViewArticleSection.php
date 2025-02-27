<?php

namespace App\Filament\Resources\ArticleSectionResource\Pages;

use App\Filament\Resources\ArticleSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewArticleSection extends ViewRecord
{
    protected static string $resource = ArticleSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->badge(),
        ];
    }
}
