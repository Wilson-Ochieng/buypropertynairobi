<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BudgetRangeResource\Pages;
use App\Models\BudgetRange;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BudgetRangeResource extends Resource
{
    protected static ?string $model = BudgetRange::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Budget Ranges';
    protected static ?string $navigationGroup = 'Lookups';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('purpose')
                ->options(['sale' => 'Sale', 'rent' => 'Rent'])
                ->required()->native(false),
            Forms\Components\Textarea::make('description')
                ->label('Marketing description')
                ->helperText('Shown on the budget landing page when no custom Category Page exists.')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('label')->required()->maxLength(255),
            Forms\Components\TextInput::make('min_value')->numeric()
                ->helperText('Leave empty for "no lower bound"'),
            Forms\Components\TextInput::make('max_value')->numeric()
                ->helperText('Leave empty for "no upper bound"'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('purpose')->badge()
                ->colors(['success' => 'sale', 'info' => 'rent'])->sortable(),
            Tables\Columns\TextColumn::make('label')->searchable()->weight('semibold'),
            Tables\Columns\TextColumn::make('min_value')->numeric()->toggleable(),
            Tables\Columns\TextColumn::make('max_value')->numeric()->toggleable(),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->numeric(),
        ])
            ->defaultSort('purpose')->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('purpose')
                    ->options(['sale' => 'Sale', 'rent' => 'Rent'])
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBudgetRanges::route('/'),
            'create' => Pages\CreateBudgetRange::route('/create'),
            'edit' => Pages\EditBudgetRange::route('/{record}/edit'),
        ];
    }
}