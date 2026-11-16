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
    protected static ?string $navigationLabel = 'Group Info';
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
                ->schema([
                    Forms\Components\TextInput::make('hero_title')
                        ->label('Hero Title')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('hero_subtitle')
                        ->label('Hero Subtitle')
                        ->maxLength(255),
                ]),

            Forms\Components\Section::make('Brand')
                ->schema([
                    Forms\Components\TextInput::make('brand_tenet')
                        ->label('Brand Tenet')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('intro_text')
                        ->label('Introduction Text')
                        ->rows(12)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Key Stats')
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('founded_year')->label('Founded Year'),
                    Forms\Components\TextInput::make('registered_capital')->label('Registered Capital'),
                    Forms\Components\TextInput::make('total_area')->label('Total Planned Area'),
                    Forms\Components\TextInput::make('planned_homes')->label('Planned Homes'),
                    Forms\Components\TextInput::make('hotels_count')->label('Four-Star Hotels'),
                    Forms\Components\TextInput::make('hq_city')->label('Headquarters City'),
                    Forms\Components\TextInput::make('origin_city')->label('Origin City'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand_tenet')->label('Brand Tenet')->limit(60),
                Tables\Columns\TextColumn::make('founded_year')->label('Founded'),
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