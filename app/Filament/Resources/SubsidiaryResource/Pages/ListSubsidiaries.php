<?php

namespace App\Filament\Resources\SubsidiaryResource\Pages;

use App\Filament\Resources\SubsidiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubsidiaries extends ListRecords
{
    protected static string $resource = SubsidiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
