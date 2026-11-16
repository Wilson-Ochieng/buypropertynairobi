<?php

namespace App\Filament\Resources\GroupInfoResource\Pages;

use App\Filament\Resources\GroupInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGroupInfos extends ManageRecords
{
    protected static string $resource = GroupInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
