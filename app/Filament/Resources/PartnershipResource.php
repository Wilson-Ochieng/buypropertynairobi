<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PartnershipResource\Pages;
use App\Models\Partnership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartnershipResource extends Resource
{
    protected static ?string $model = Partnership::class;
    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';
    protected static ?string $navigationLabel = 'Partnerships';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Type')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->label('Partnership type')
                        ->options([
                            'land' => 'Land Partnership',
                            'agency' => 'Real Estate Agency',
                            'freelancer' => 'Freelance Agent',
                        ])
                        ->required()
                        ->native(false)
                        ->unique(ignoreRecord: true)
                        ->helperText('Only one active record per type.'),
                ]),

            Forms\Components\Section::make('Content')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('subtitle')
                        ->maxLength(255),

                    Forms\Components\Textarea::make('description')
                        ->rows(5)
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('benefits')
                        ->label('Benefits (for agency/freelancer)')
                        ->simple(
                            Forms\Components\TextInput::make('label')
                                ->required()
                                ->maxLength(255)
                        )
                        ->helperText('Each benefit becomes a bullet on the public page.')
                        ->addActionLabel('Add benefit')
                        ->defaultItems(0)
                        ->columnSpanFull(),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('cta_label')
                            ->label('Button label')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('cta_url')
                            ->label('Button URL')
                            ->maxLength(500)
                            ->placeholder('mailto:... or /path'),
                    ]),
                ]),

            Forms\Components\Section::make('Contact')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('contact_name')->maxLength(255),
                    Forms\Components\TextInput::make('contact_email')->email(),
                    Forms\Components\TextInput::make('contact_phone')->tel(),
                    Forms\Components\Toggle::make('is_active')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'warning' => 'land',
                        'success' => 'agency',
                        'info' => 'freelancer',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'land' => 'Land',
                        'agency' => 'Agency',
                        'freelancer' => 'Freelancer',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('title')->searchable()->weight('semibold'),
                Tables\Columns\TextColumn::make('contact_email')->label('Email')->copyable()->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->since()->toggleable(),
            ])
            ->defaultSort('type')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartnerships::route('/'),
        ];
    }
}