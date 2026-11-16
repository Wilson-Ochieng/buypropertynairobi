<?php

namespace App\Filament\Resources\CategoryPageResource\Pages;

use App\Filament\Resources\CategoryPageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryPage extends CreateRecord
{
    protected static string $resource = CategoryPageResource::class;
}
