<?php
namespace App\Filament\Resources\ContactSubmissionResource\Pages;

use App\Filament\Resources\ContactSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactSubmission extends ViewRecord
{
    protected static string $resource = ContactSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('reply_mailto')
                ->label('Reply by email')
                ->icon('heroicon-o-envelope')
                ->url(fn() => 'mailto:' . $this->record->email
                    . '?subject=' . urlencode('Re: your enquiry with Nanchong Group'))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}