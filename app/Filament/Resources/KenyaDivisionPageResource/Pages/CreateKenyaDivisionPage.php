<?php
namespace App\Filament\Resources\KenyaDivisionPageResource\Pages;

use App\Filament\Resources\KenyaDivisionPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKenyaDivisionPage extends CreateRecord
{
    protected static string $resource = KenyaDivisionPageResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('edit', ['record' => $this->record]);
    }
}