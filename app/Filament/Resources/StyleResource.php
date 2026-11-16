<?php
namespace App\Filament\Resources;

use App\Filament\Resources\StyleResource\Pages;
use App\Models\Style;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class StyleResource extends Resource
{
    protected static ?string $model = Style::class;
    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?string $navigationLabel = 'Styles';
    protected static ?string $navigationGroup = 'Lookups';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->live(onBlur: true)
                ->afterStateUpdated(fn(string $op, $state, Set $set) =>
                    $op === 'create' ? $set('slug', Str::slug($state)) : null),
            Forms\Components\Textarea::make('description')
                ->label('Marketing description')
                ->helperText('Shown on the style landing page when no custom Category Page exists.')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Forms\Components\Toggle::make('show_in_type')
                ->label('Show in "Type" column of the mega menu')
                ->helperText('Off = only in "Style" column. On = also in "Type".'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->weight('semibold'),
            Tables\Columns\IconColumn::make('show_in_type')->label('Type col')->boolean(),
            Tables\Columns\TextColumn::make('unit_types_count')->counts('unitTypes')->label('Units'),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->numeric(),
        ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStyles::route('/'),
            'create' => Pages\CreateStyle::route('/create'),
            'edit' => Pages\EditStyle::route('/{record}/edit'),
        ];
    }
}