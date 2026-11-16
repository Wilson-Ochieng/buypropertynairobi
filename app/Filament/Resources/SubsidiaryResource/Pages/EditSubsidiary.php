<?php

namespace App\Filament\Resources\SubsidiaryResource\Pages;

use App\Filament\Resources\SubsidiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubsidiary extends EditRecord
{
    protected static string $resource = SubsidiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
