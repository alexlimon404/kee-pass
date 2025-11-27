<?php

namespace App\Filament\Resources\ArticleSectionResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ArticleSectionResource;
use Filament\Resources\Pages\EditRecord;

class EditArticleSection extends EditRecord
{
    protected static string $resource = ArticleSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
