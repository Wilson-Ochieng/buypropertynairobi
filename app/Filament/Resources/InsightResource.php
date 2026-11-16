<?php
namespace App\Filament\Resources;

use App\Filament\Resources\InsightResource\Pages;
use App\Models\Insight;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class InsightResource extends Resource
{
    protected static ?string $model = Insight::class;
    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
    protected static ?string $navigationLabel = 'Insights';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Basic')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Set $set) {
                            if ($operation === 'create') {
                                $set('slug', Str::slug($state));
                            }
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Forms\Components\Select::make('location')
                        ->label('Location (matches a project location)')
                        ->options(fn() => Project::whereNotNull('location')
                            ->distinct()
                            ->orderBy('location')
                            ->pluck('location', 'location')
                            ->toArray())
                        ->searchable()
                        ->required()
                        ->helperText('Projects in this location will link to this insight.'),

                    Forms\Components\Textarea::make('summary')
                        ->rows(3)
                        ->maxLength(500)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('body')
                        ->columnSpanFull()
                        ->fileAttachmentsDirectory('insights'),
                    Forms\Components\Select::make('category')
                        ->label('Content type')
                        ->options([
                            'area_guide' => 'Area Guide',
                            'market' => 'Market Insight',
                        ])
                        ->default('area_guide')
                        ->required()
                        ->native(false),
                ]),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('cover_image')
                        ->image()
                        ->directory('insights')
                        ->imageEditor(),
                ]),

            Forms\Components\Section::make('SEO')
                ->schema([
                    Forms\Components\TextInput::make('meta_title')->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')->rows(2)->maxLength(500),
                ]),

            Forms\Components\Section::make('Visibility')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_published')->default(true),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->height(40)->width(56),
                Tables\Columns\TextColumn::make('title')->searchable()->weight('semibold')->limit(50),
                Tables\Columns\TextColumn::make('location')->searchable()->badge()->color('info'),
                Tables\Columns\BadgeColumn::make('category')
                    ->colors(['success' => 'area_guide', 'info' => 'market'])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'area_guide' => 'Area Guide',
                        'market' => 'Market Insight',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_published')->label('Published')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->numeric()->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')->since()->toggleable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('location')
                    ->options(fn() => Insight::distinct()->orderBy('location')
                        ->pluck('location', 'location')->toArray()),
                Tables\Filters\SelectFilter::make('category')
                    ->options(['area_guide' => 'Area Guides', 'market' => 'Market Insights']),
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
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
            'index' => Pages\ListInsights::route('/'),
            'create' => Pages\CreateInsight::route('/create'),
            'edit' => Pages\EditInsight::route('/{record}/edit'),
        ];
    }
}