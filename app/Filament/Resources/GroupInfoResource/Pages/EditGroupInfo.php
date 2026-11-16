<?php
namespace App\Filament\Resources\GroupInfoResource\Pages;

use App\Filament\Resources\GroupInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupInfo extends EditRecord
{
    protected static string $resource = GroupInfoResource::class;

    protected function getHeaderActions(): array
    {
        return []; // no delete for singleton
    }
}