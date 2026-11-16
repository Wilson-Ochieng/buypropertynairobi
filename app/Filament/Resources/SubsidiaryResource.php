<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SubsidiaryResource\Pages;
use App\Models\Subsidiary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubsidiaryResource extends Resource
{
    protected static ?string $model = Subsidiary::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Subsidiaries';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('qualification')
                ->maxLength(255)
                ->placeholder('e.g. First-class qualification'),
            Forms\Components\TextInput::make('sort_order')
                ->numeric()->default(0),
            Forms\Components\Textarea::make('description')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('logo')
                ->image()
                ->directory('subsidiaries')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')->label('Logo')->height(40),
                Tables\Columns\TextColumn::make('name')->searchable()->weight('semibold'),
                Tables\Columns\TextColumn::make('qualification')->toggleable()->limit(40),
                Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubsidiaries::route('/'),
        ];
    }
}