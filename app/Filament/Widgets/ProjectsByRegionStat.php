<?php
namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectsByRegionStat extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $kenya = Project::whereHas('country', fn ($q) => $q->where('slug', 'kenya'))->count();
        $china = Project::whereHas('country', fn ($q) => $q->where('slug', 'china'))->count();

        $totalLeads = ContactSubmission::count();
        $newLeads   = ContactSubmission::whereDate('created_at', today())->count();

        return [
            Stat::make('Kenya Projects', $kenya)
                ->description('Active Kenya division')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('success'),

            Stat::make('China Projects', $china)
                ->description('Group track record')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('warning'),

            Stat::make('Total Leads', $totalLeads)
                ->description("{$newLeads} new today")
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color('primary'),
        ];
    }
}