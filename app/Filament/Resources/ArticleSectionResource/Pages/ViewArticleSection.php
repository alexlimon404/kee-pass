<?php

namespace App\Filament\Resources\ArticleSectionResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\ArticleSectionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewArticleSection extends ViewRecord
{
    protected static string $resource = ArticleSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->badge(),
        ];
    }
}
