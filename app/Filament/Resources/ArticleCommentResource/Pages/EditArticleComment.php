<?php

namespace App\Filament\Resources\ArticleCommentResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ArticleCommentResource;
use Filament\Resources\Pages\EditRecord;

class EditArticleComment extends EditRecord
{
    protected static string $resource = ArticleCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->badge(),
        ];
    }
}
