<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationLabel = 'Leads / Enquiries';
    protected static ?string $navigationGroup = 'Leads';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Lead';
    protected static ?string $pluralModelLabel = 'Leads';

    public static function canCreate(): bool { return false; }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Submission')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')->disabled(),
                        Forms\Components\TextInput::make('phone')->disabled(),
                        Forms\Components\TextInput::make('email')->disabled(),
                        Forms\Components\Select::make('source')->disabled()->options(self::sourceOptions()),
                        Forms\Components\Textarea::make('message')->disabled()->rows(4)->columnSpanFull(),
                    ]),
                ]),

            Forms\Components\Section::make('Follow-up')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options(['new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed'])
                        ->required()
                        ->native(false),

                    Forms\Components\DateTimePicker::make('contacted_at')
                        ->label('Contacted at'),

                    Forms\Components\Textarea::make('admin_notes')
                        ->label('Internal notes (not visible to the visitor)')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->weight('semibold'),
                Tables\Columns\TextColumn::make('phone')->copyable()->searchable(),
                Tables\Columns\TextColumn::make('email')->copyable()->searchable()->toggleable(),
                Tables\Columns\BadgeColumn::make('source')
                    ->colors([
                        'success' => 'bay',
                        'info'    => 'island',
                        'warning' => 'partnership',
                        'gray'    => 'general',
                    ])
                    ->formatStateUsing(fn ($state) => self::sourceOptions()[$state] ?? $state),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'new',
                        'info'    => 'contacted',
                        'success' => 'closed',
                    ]),

                Tables\Columns\TextColumn::make('created_at')->label('Received')->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed'])
                    ->default('new'),
                Tables\Filters\SelectFilter::make('source')->options(self::sourceOptions()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_contacted')
                        ->label('Mark as contacted')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->update([
                            'status' => 'contacted',
                            'contacted_at' => now(),
                        ])),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_csv')
                    ->label('Export CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn () => self::exportCsv()),
            ]);
    }

    public static function sourceOptions(): array
    {
        return [
            'bay'         => 'Longines Bay',
            'island'      => 'Longines Island',
            'partnership' => 'Land Partnership',
            'general'     => 'General',
        ];
    }

    public static function exportCsv()
    {
        $leads = ContactSubmission::latest()->get();

        $filename = 'leads-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($leads) {
            $fh = fopen('php://output', 'w');
            fputcsv($fh, ['ID', 'Name', 'Phone', 'Email', 'Source', 'Status', 'Message', 'Received', 'Contacted at']);

            foreach ($leads as $lead) {
                fputcsv($fh, [
                    $lead->id,
                    $lead->name,
                    $lead->phone,
                    $lead->email,
                    self::sourceOptions()[$lead->source] ?? $lead->source,
                    $lead->status,
                    $lead->message,
                    $lead->created_at?->format('Y-m-d H:i'),
                    $lead->contacted_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($fh);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'view'  => Pages\ViewContactSubmission::route('/{record}'),
            'edit'  => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }
}