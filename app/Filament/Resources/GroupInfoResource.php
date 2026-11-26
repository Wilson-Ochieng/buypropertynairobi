<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupInfoResource\Pages;
use App\Models\GroupInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GroupInfoResource extends Resource
{
    protected static ?string $model = GroupInfo::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Company Info';
    protected static ?string $modelLabel = 'Company Info';
    protected static ?string $pluralModelLabel = 'Company Info';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    /** Singleton: no create/delete buttons */
    public static function canCreate(): bool
    {
        return GroupInfo::count() === 0;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    /** Route straight to edit */
    public static function getNavigationUrl(): string
    {
        $record = GroupInfo::first();
        return $record
            ? static::getUrl('edit', ['record' => $record])
            : static::getUrl('create');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Hero')
                ->description('Headline shown at the top of the About page.')
                ->schema([
                    Forms\Components\TextInput::make('hero_title')
                        ->label('Hero Title')
                        ->placeholder('Buy Property Nairobi')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('hero_subtitle')
                        ->label('Hero Subtitle')
                        ->placeholder('Premium properties. Trusted expertise. Brighter futures.')
                        ->maxLength(255),
                ]),

            Forms\Components\Section::make('About')
                ->description('Separate paragraphs with a blank line.')
                ->schema([
                    Forms\Components\TextInput::make('brand_tenet')
                        ->label('Tagline')
                        ->placeholder('Premium properties. Trusted expertise. Brighter futures.')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('intro_text')
                        ->label('Introduction Text')
                        ->rows(10)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Company Snapshot')
                ->description('Optional. Leave blank to hide.')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('founded_year')->label('Founded Year'),
                    Forms\Components\TextInput::make('hq_city')->label('Office Location')->placeholder('Nairobi, Kenya'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hero_title')->label('Hero Title')->limit(40),
                Tables\Columns\TextColumn::make('brand_tenet')->label('Tagline')->limit(60),
                Tables\Columns\TextColumn::make('updated_at')->label('Updated')->since(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupInfos::route('/'),
            'create' => Pages\CreateGroupInfo::route('/create'),
            'edit' => Pages\EditGroupInfo::route('/{record}/edit'),
        ];
    }
}
