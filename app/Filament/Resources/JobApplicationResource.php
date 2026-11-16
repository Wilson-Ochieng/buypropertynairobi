<?php
namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Job Applications';
    protected static ?string $navigationGroup = 'Leads';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Applicant')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')->disabled(),
                    Forms\Components\TextInput::make('email')->disabled(),
                    Forms\Components\TextInput::make('phone')->disabled(),
                    Forms\Components\TextInput::make('current_location')->disabled(),
                    Forms\Components\TextInput::make('linkedin_url')->disabled(),
                    Forms\Components\Select::make('job_listing_id')
                        ->relationship('jobListing', 'title')
                        ->disabled(),
                ]),

            Forms\Components\Section::make('Cover Letter')->schema([
                Forms\Components\Textarea::make('cover_letter')->rows(6)->disabled()->columnSpanFull(),
            ]),

            Forms\Components\Section::make('CV')->schema([
                Forms\Components\TextInput::make('cv_original_name')->label('File')->disabled(),
                Forms\Components\Placeholder::make('cv_download')
                    ->content(fn($record) => $record && $record->cv_path
                        ? new \Illuminate\Support\HtmlString(
                            '<a href="' . asset('storage/' . $record->cv_path) . '" target="_blank" class="text-primary-600 underline">Download CV →</a>'
                        )
                        : 'No file'),
            ]),

            Forms\Components\Section::make('Status')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'new' => 'New',
                            'reviewing' => 'Reviewing',
                            'shortlisted' => 'Shortlisted',
                            'rejected' => 'Rejected',
                            'hired' => 'Hired',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\Textarea::make('admin_notes')->rows(3)->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->weight('semibold'),
                Tables\Columns\TextColumn::make('jobListing.title')->label('Role')->limit(30),
                Tables\Columns\TextColumn::make('email')->copyable()->searchable(),
                Tables\Columns\TextColumn::make('phone')->copyable()->toggleable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'new',
                        'info' => 'reviewing',
                        'primary' => 'shortlisted',
                        'danger' => 'rejected',
                        'success' => 'hired',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'reviewing' => 'Reviewing',
                        'shortlisted' => 'Shortlisted',
                        'rejected' => 'Rejected',
                        'hired' => 'Hired',
                    ])
                    ->default('new'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobApplications::route('/'),
            'view' => Pages\ViewJobApplication::route('/{record}'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}