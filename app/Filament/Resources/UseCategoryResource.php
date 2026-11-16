<?php
namespace App\Filament\Resources;

use App\Filament\Resources\UseCategoryResource\Pages;
use App\Models\UseCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UseCategoryResource extends Resource
{
    protected static ?string $model = UseCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Uses';
    protected static ?string $navigationGroup = 'Lookups';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()->maxLength(255)->live(onBlur: true)
                ->afterStateUpdated(fn(string $op, $state, Set $set) =>
                    $op === 'create' ? $set('slug', Str::slug($state)) : null),
            Forms\Components\Textarea::make('description')
                ->label('Marketing description')
                ->helperText('Shown on the use landing page when no custom Category Page exists.')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->weight('semibold'),
            Tables\Columns\TextColumn::make('slug')->toggleable(),
            Tables\Columns\TextColumn::make('projects_count')->counts('projects')->label('Projects'),
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
            'index' => Pages\ListUseCategories::route('/'),
            'create' => Pages\CreateUseCategory::route('/create'),
            'edit' => Pages\EditUseCategory::route('/{record}/edit'),
        ];
    }
}