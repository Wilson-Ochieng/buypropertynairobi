<?php
namespace App\Filament\Resources\GroupInfoResource\Pages;

use App\Filament\Resources\GroupInfoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGroupInfo extends CreateRecord
{
    protected static string $resource = GroupInfoResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->record]);
    }
}