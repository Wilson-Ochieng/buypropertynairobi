<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SiteContactResource\Pages;
use App\Models\SiteContact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteContactResource extends Resource
{
    protected static ?string $model = SiteContact::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Site Contacts';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('role')
                ->maxLength(255)
                ->placeholder('e.g. Client Contact / Chairman'),
            Forms\Components\TextInput::make('phone')->tel()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->maxLength(255),
            Forms\Components\Toggle::make('is_primary')
                ->label('Primary contact (shown on homepage)')
                ->helperText('Only one should be primary.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->weight('semibold'),
                Tables\Columns\TextColumn::make('role')->toggleable(),
                Tables\Columns\TextColumn::make('phone')->copyable()->toggleable(),
                Tables\Columns\TextColumn::make('email')->copyable()->searchable(),
                Tables\Columns\IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean(),
            ])
            ->defaultSort('is_primary', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteContacts::route('/'),
        ];
    }
}