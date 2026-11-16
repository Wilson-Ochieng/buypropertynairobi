<?php

namespace App\Filament\Resources\UnitTypeLookupResource\Pages;

use App\Filament\Resources\UnitTypeLookupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnitTypeLookup extends EditRecord
{
    protected static string $resource = UnitTypeLookupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
