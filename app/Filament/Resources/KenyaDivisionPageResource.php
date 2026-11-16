<?php
namespace App\Filament\Resources;

use App\Filament\Resources\KenyaDivisionPageResource\Pages;
use App\Models\KenyaDivisionPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KenyaDivisionPageResource extends Resource
{
    protected static ?string $model = KenyaDivisionPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Kenya Division';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 6;

    public static function canCreate(): bool
    {
        return KenyaDivisionPage::count() === 0;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getNavigationUrl(): string
    {
        $record = KenyaDivisionPage::first();
        return $record
            ? static::getUrl('edit', ['record' => $record])
            : static::getUrl('create');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('hero_image')
                ->label('Hero Image')
                ->image()
                ->directory('kenya')
                ->imageEditor(),
            Forms\Components\Textarea::make('intro_text')
                ->label('Kenya Division Intro')
                ->rows(8)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('updated_at')->since(),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListKenyaDivisionPages::route('/'),
            'create' => Pages\CreateKenyaDivisionPage::route('/create'),
            'edit'   => Pages\EditKenyaDivisionPage::route('/{record}/edit'),
        ];
    }
}