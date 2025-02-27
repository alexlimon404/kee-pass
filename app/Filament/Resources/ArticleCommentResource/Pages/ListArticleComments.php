<?php

namespace App\Filament\Resources\ArticleCommentResource\Pages;

use App\Filament\Resources\ArticleCommentResource;
use Filament\Resources\Pages\ListRecords;

class ListArticleComments extends ListRecords
{
    protected static string $resource = ArticleCommentResource::class;
}
