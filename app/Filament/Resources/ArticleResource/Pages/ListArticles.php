<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\ArticleResource;
use App\Models\ArticleSection;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->badge(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make('All')->query(fn ($query) => $query),
            ...$this->getTypes(),
        ];
    }

    private function getTypes(): array
    {
        foreach (ArticleSection::get()->pluck('name', 'id') as $key => $value) {
            $types[$key] = Tab::make($value)->query(fn ($query) => $query->where('section_id', $key));
        }
        return $types;
    }
}
