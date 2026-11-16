<?php
namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Job Listings';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Role')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Set $set) {
                            if ($operation === 'create') {
                                $set('slug', Str::slug($state));
                            }
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->required()->unique(ignoreRecord: true),

                    Forms\Components\TextInput::make('department'),
                    Forms\Components\TextInput::make('location'),
                    Forms\Components\Select::make('employment_type')
                        ->options([
                            'Full-time' => 'Full-time',
                            'Part-time' => 'Part-time',
                            'Contract' => 'Contract',
                            'Internship' => 'Internship',
                        ])
                        ->native(false),
                    Forms\Components\TextInput::make('salary_range'),
                ]),

            Forms\Components\Section::make('Description')
                ->schema([
                    Forms\Components\Textarea::make('summary')->rows(2)->maxLength(500),
                    Forms\Components\RichEditor::make('description')
                        ->fileAttachmentsDirectory('jobs')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('requirements')
                        ->fileAttachmentsDirectory('jobs')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Application Settings')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('contact_email')
                        ->label('Where applications for this role go')
                        ->email()
                        ->helperText('Leave blank to use the default careers email.'),
                    Forms\Components\DatePicker::make('expires_at')
                        ->helperText('Applications close on this date.'),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->weight('semibold'),
                Tables\Columns\TextColumn::make('department')->toggleable(),
                Tables\Columns\TextColumn::make('location')->toggleable(),
                Tables\Columns\BadgeColumn::make('employment_type')->colors(['primary']),
                Tables\Columns\TextColumn::make('applications_count')
                    ->counts('applications')
                    ->label('Applications')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('expires_at')
                    ->date('M j, Y')
                    ->badge()
                    ->color(fn(JobListing $record) => $record->is_expired ? 'danger' : 'success'),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}