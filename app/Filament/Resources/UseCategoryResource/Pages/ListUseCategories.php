<?php

namespace App\Filament\Resources\UseCategoryResource\Pages;

use App\Filament\Resources\UseCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUseCategories extends ListRecords
{
    protected static string $resource = UseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
