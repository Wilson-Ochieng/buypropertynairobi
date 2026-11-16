<?php

namespace App\Filament\Resources\CategoryPageResource\Pages;

use App\Filament\Resources\CategoryPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryPage extends EditRecord
{
    protected static string $resource = CategoryPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
