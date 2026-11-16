<?php
namespace App\Filament\Resources\GroupInfoResource\Pages;

use App\Filament\Resources\GroupInfoResource;
use Filament\Resources\Pages\ListRecords;

class ListGroupInfos extends ListRecords
{
    protected static string $resource = GroupInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->visible(fn () => \App\Models\GroupInfo::count() === 0),
        ];
    }
}