<?php
namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentLeadsTable extends BaseWidget
{
    protected static ?string $heading = 'Recent leads';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(ContactSubmission::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email')->copyable(),
                Tables\Columns\BadgeColumn::make('source')
                    ->colors([
                        'success' => 'bay',
                        'info' => 'island',
                        'warning' => 'partnership',
                        'gray' => 'general',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->since(),
            ]);
    }
}