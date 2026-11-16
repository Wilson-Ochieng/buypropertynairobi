<?php
namespace App\Filament\Resources\KenyaDivisionPageResource\Pages;

use App\Filament\Resources\KenyaDivisionPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKenyaDivisionPages extends ListRecords
{
    protected static string $resource = KenyaDivisionPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn() => \App\Models\KenyaDivisionPage::count() === 0),
        ];
    }
}