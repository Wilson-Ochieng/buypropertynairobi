<?php
namespace App\Filament\Resources\KenyaDivisionPageResource\Pages;

use App\Filament\Resources\KenyaDivisionPageResource;
use Filament\Resources\Pages\EditRecord;

class EditKenyaDivisionPage extends EditRecord
{
    protected static string $resource = KenyaDivisionPageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}