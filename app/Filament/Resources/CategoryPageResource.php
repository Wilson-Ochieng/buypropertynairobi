<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CategoryPageResource\Pages;
use App\Models\CategoryPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryPageResource extends Resource
{
    protected static ?string $model = CategoryPage::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Category Pages';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Category')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('purpose')
                        ->options(['buy' => 'Buy', 'rent' => 'Rent'])
                        ->required()->native(false)->live(),

                    Forms\Components\Select::make('category_type')
                        ->options([
                            'location' => 'Location',
                            'use' => 'Use',
                            'style' => 'Style',
                            'budget' => 'Budget',
                            'type' => 'Type',
                        ])
                        ->required()->native(false)->live(),

                    Forms\Components\TextInput::make('filter_value')
                        ->required()
                        ->helperText('The value the projects are filtered by. For location: "Kilimani". For use: "family". For style: "duplex". For budget: "10000000-20000000". For type: "apartment".')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('slug')
                        ->required()->unique(ignoreRecord: true)
                        ->helperText('URL slug — e.g. "kilimani", "10m-20m".')
                        ->live(onBlur: true),
                ]),

            Forms\Components\Section::make('Content')
                ->schema([
                    Forms\Components\TextInput::make('h1')
                        ->label('Page H1 heading')
                        ->required()
                        ->helperText('e.g. "Properties for Sale in Kilimani"')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $op, $state, Set $set, $get) {
                            if ($op === 'create' && empty($get('slug'))) {
                                $set('slug', Str::slug($state));
                            }
                        }),

                    Forms\Components\RichEditor::make('description')
                        ->label('Page description')
                        ->helperText('Marketing copy — shown above the project grid.')
                        ->columnSpanFull()
                        ->fileAttachmentsDirectory('category-pages'),

                    Forms\Components\FileUpload::make('hero_image')
                        ->image()->directory('category-pages/heroes'),
                ]),
            Forms\Components\Select::make('bedrooms')
                ->label('Bedrooms (for style pages only)')
                ->options([
                    0 => 'Studio',
                    1 => '1 Bedroom',
                    2 => '2 Bedrooms',
                    3 => '3 Bedrooms',
                    4 => '4+ Bedrooms',
                ])
                ->nullable()
                ->native(false)
                ->visible(fn(Get $get) => $get('category_type') === 'style')
                ->placeholder('Any — applies to all bedrooms')
                ->helperText('Leave empty for "any bedroom". Set to specific count for a filtered page.'),

            Forms\Components\Section::make('SEO')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')->rows(2)->maxLength(500),
                ]),

            Forms\Components\Section::make('Visibility')
                ->schema([
                    Forms\Components\Toggle::make('is_published')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('h1')->searchable()->weight('semibold')->limit(40),
            Tables\Columns\TextColumn::make('bedrooms')
                ->label('Beds')
                ->formatStateUsing(fn($state) => match ((int) $state) {
                    0 => 'Studio',
                    1 => '1-Bed',
                    2 => '2-Bed',
                    3 => '3-Bed',
                    4 => '4+ Bed',
                    default => $state,
                })
                ->toggleable(),
            Tables\Columns\BadgeColumn::make('purpose')
                ->colors(['success' => 'buy', 'info' => 'rent']),
            Tables\Columns\BadgeColumn::make('category_type')
                ->colors([
                    'gray' => 'location',
                    'warning' => 'use',
                    'primary' => 'style',
                    'success' => 'budget',
                    'info' => 'type',
                ]),
            Tables\Columns\TextColumn::make('filter_value')->toggleable(),
            Tables\Columns\TextColumn::make('slug')->toggleable(),
            Tables\Columns\IconColumn::make('is_published')->boolean(),
            Tables\Columns\TextColumn::make('updated_at')->since()->toggleable(),
        ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('purpose')->options(['buy' => 'Buy', 'rent' => 'Rent']),
                Tables\Filters\SelectFilter::make('category_type')->options([
                    'location' => 'Location',
                    'use' => 'Use',
                    'style' => 'Style',
                    'budget' => 'Budget',
                    'type' => 'Type',
                ]),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryPages::route('/'),
            'create' => Pages\CreateCategoryPage::route('/create'),
            'edit' => Pages\EditCategoryPage::route('/{record}/edit'),
        ];
    }
}