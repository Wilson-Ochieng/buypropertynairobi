<?php
namespace App\Filament\Resources\JobApplicationResource\Pages;

use App\Filament\Resources\JobApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJobApplication extends ViewRecord
{
    protected static string $resource = JobApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply_email')
                ->label('Reply by email')
                ->icon('heroicon-o-envelope')
                ->url(fn() => 'mailto:' . $this->record->email
                    . '?subject=' . urlencode('Re: Your application — Nanchong Group'))
                ->openUrlInNewTab(),

            Actions\Action::make('download_cv')
                ->label('Download CV')
                ->icon('heroicon-o-arrow-down-tray')
                ->visible(fn() => !empty($this->record->cv_path))
                ->url(fn() => asset('storage/' . $this->record->cv_path))
                ->openUrlInNewTab(),

            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}