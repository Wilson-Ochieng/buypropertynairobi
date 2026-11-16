<?php
namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use Filament\Widgets\ChartWidget;

class LeadsBySourceChart extends ChartWidget
{
    protected static ?string $heading = 'Leads by source';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $sources = ['bay', 'island', 'partnership', 'general'];
        $labels = ['Longines Bay', 'Longines Island', 'Land Partnership', 'General'];

        $counts = collect($sources)
            ->map(fn($s) => ContactSubmission::where('source', $s)->count())
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Leads',
                    'data' => $counts,
                    'backgroundColor' => ['#C09C7A', '#9B897A', '#B1AFAA', '#BFC1B1'],
                ]
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}