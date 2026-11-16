<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\ProjectVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Projects';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Project')
                ->columnSpanFull()
                ->tabs([

                    // ───────── Basic ─────────
                    Forms\Components\Tabs\Tab::make('Basic')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('name')
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

                                Forms\Components\Select::make('country_id')
                                    ->label('Country')
                                    ->relationship('country', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\Select::make('use_id')
                                    ->label('Use category')
                                    ->relationship('useCategory', 'name')
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\TextInput::make('location')
                                    ->label('Location (within country)')
                                    ->placeholder('e.g. Kilimani, Westlands, Nanchang')
                                    ->required(),

                                Forms\Components\TextInput::make('city')
                                    ->maxLength(255),

                                Forms\Components\Select::make('status')
                                    ->label('Project status')
                                    ->options([
                                        'ongoing' => 'Ongoing',
                                        'completed' => 'Completed',
                                        'off_plan' => 'Off-Plan',
                                    ])
                                    ->default('ongoing')
                                    ->required()
                                    ->native(false),

                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),

                                Forms\Components\TextInput::make('address')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('description')
                                    ->rows(6)
                                    ->columnSpanFull(),

                                Forms\Components\TagsInput::make('features')
                                    ->label('Features & amenities')
                                    ->placeholder('Add feature and press Enter (e.g. Swimming pool)')
                                    ->helperText('Stored as a list — one feature per tag.')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('investment'),
                                Forms\Components\TextInput::make('land_area'),
                                Forms\Components\TextInput::make('construction_area'),
                                Forms\Components\TextInput::make('unit_count'),
                                Forms\Components\TextInput::make('distance_subway'),

                                Forms\Components\TextInput::make('contact_email')
                                    ->email()
                                    ->helperText('Enquiries from this project will be routed here.'),

                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label('WhatsApp number')
                                    ->placeholder('254710998888')
                                    ->helperText('Digits only, with country code. Overrides the site default.'),

                                Forms\Components\TextInput::make('latitude')
                                    ->numeric()
                                    ->step(0.0000001),

                                Forms\Components\TextInput::make('longitude')
                                    ->numeric()
                                    ->step(0.0000001),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured on homepage'),
                            ]),
                        ]),

                    // ───────── Unit Types ─────────
                    Forms\Components\Tabs\Tab::make('Unit Types')
                        ->icon('heroicon-o-home-modern')
                        ->schema([
                            Forms\Components\Repeater::make('unitTypes')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\Select::make('unit_type_lookup_id')
                                            ->label('Unit type')
                                            ->relationship('unitTypeLookup', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(fn($record) => $record === null),

                                        Forms\Components\Select::make('category')
                                            ->options(['residential' => 'Residential', 'commercial' => 'Commercial'])
                                            ->required()
                                            ->native(false),

                                        Forms\Components\Select::make('purpose')
                                            ->options(['sale' => 'For Sale', 'rent' => 'For Rent', 'both' => 'Both'])
                                            ->default('sale')
                                            ->required()
                                            ->native(false),
                                    ]),

                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->placeholder('Studio / 1-Bedroom / Retail…')
                                            ->helperText('Display name shown on the site.')
                                            ->required(),

                                        Forms\Components\Select::make('style_id')
                                            ->label('Style')
                                            ->relationship('style', 'name')
                                            ->searchable()
                                            ->preload(),

                                        Forms\Components\TextInput::make('bedrooms')
                                            ->numeric()
                                            ->minValue(0)
                                            ->helperText('0 = Studio'),
                                    ]),

                                    Forms\Components\Grid::make(4)->schema([
                                        Forms\Components\TextInput::make('size_min_sqm')
                                            ->numeric()
                                            ->label('Min size (m²)'),

                                        Forms\Components\TextInput::make('size_max_sqm')
                                            ->numeric()
                                            ->label('Max size (m²)'),

                                        Forms\Components\TextInput::make('price_kes')
                                            ->numeric()
                                            ->prefix('KES')
                                            ->helperText('Leave blank for "Price on request"'),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                    Forms\Components\Toggle::make('price_negotiable')
                                        ->label('Price negotiable'),

                                    Forms\Components\TagsInput::make('features')
                                        ->label('Unit-specific amenities')
                                        ->placeholder('Add amenity and press Enter (Private balcony)')
                                        ->helperText('Amenities unique to this unit type. Leave blank to inherit from the project.')
                                        ->columnSpanFull(),
                                    Forms\Components\Repeater::make('videos')
                                        ->label('Unit videos')
                                        ->relationship()
                                        ->schema([
                                            Forms\Components\Grid::make(3)->schema([
                                                Forms\Components\Select::make('type')
                                                    ->options([
                                                        'youtube' => 'YouTube',
                                                        'vimeo' => 'Vimeo',
                                                        'mp4' => 'Uploaded MP4',
                                                    ])
                                                    ->default('youtube')
                                                    ->required()
                                                    ->native(false)
                                                    ->live(),

                                                Forms\Components\TextInput::make('title')
                                                    ->maxLength(255)
                                                    ->placeholder('Optional — e.g. Studio walkthrough'),

                                                Forms\Components\TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0),
                                            ]),

                                            Forms\Components\TextInput::make('video_url')
                                                ->label('Video URL')
                                                ->helperText('Paste a full YouTube or Vimeo URL. ID is extracted automatically.')
                                                ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                                                ->required(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                                    $type = $get('type');
                                                    if ($state && $type) {
                                                        $set('video_id', ProjectVideo::extractVideoId($state, $type));
                                                    }
                                                })
                                                ->columnSpanFull(),

                                            Forms\Components\TextInput::make('video_id')
                                                ->label('Video ID (auto-extracted)')
                                                ->readOnly()
                                                ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                                                ->columnSpanFull(),

                                            Forms\Components\FileUpload::make('video_path')
                                                ->label('Upload video file (MP4)')
                                                ->visible(fn(Get $get) => $get('type') === 'mp4')
                                                ->required(fn(Get $get) => $get('type') === 'mp4')
                                                ->directory('units/videos')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->acceptedFileTypes(['video/mp4', 'video/webm'])
                                                ->maxSize(51200)
                                                ->columnSpanFull(),

                                            Forms\Components\FileUpload::make('thumbnail_path')
                                                ->label('Thumbnail image')
                                                ->image()
                                                ->directory('units/videos/thumbnails')
                                                ->disk('public')
                                                ->visibility('public')
                                                ->preserveFilenames(false)
                                                ->maxSize(5120)
                                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                                ->imagePreviewHeight('200')
                                                ->helperText('Optional — falls back to YouTube thumbnail or unit cover.')
                                                ->columnSpanFull(),

                                            Forms\Components\Toggle::make('is_published')
                                                ->default(true),
                                        ])
                                        ->orderColumn('sort_order')
                                        ->addActionLabel('Add unit video')
                                        ->collapsible()
                                        ->collapsed()
                                        ->defaultItems(0)
                                        ->columnSpanFull(),

                                    Forms\Components\Repeater::make('images')
                                        ->label('Unit images')
                                        ->relationship()
                                        ->schema([
                                            Forms\Components\Grid::make(3)->schema([
                                                Forms\Components\FileUpload::make('path')
                                                    ->label('Image')
                                                    ->image()
                                                    ->directory('projects/units')
                                                    ->disk('public')
                                                    ->visibility('public')
                                                    ->preserveFilenames(false)
                                                    ->maxSize(5120)
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                                    ->imagePreviewHeight('200')
                                                    ->required()
                                                    ->columnSpan(2),

                                                Forms\Components\TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0),
                                            ]),
                                        ])
                                        ->orderColumn('sort_order')
                                        ->addActionLabel('Add unit image')
                                        ->collapsible()
                                        ->collapsed()
                                        ->defaultItems(0)
                                        ->columnSpanFull(),
                                ])
                                ->orderColumn('sort_order')
                                ->addActionLabel('Add unit type')
                                ->collapsible()
                                ->defaultItems(0)
                                ->columnSpanFull(),
                        ]),

                    // ───────── Highlights ─────────
                    Forms\Components\Tabs\Tab::make('Highlights')
                        ->icon('heroicon-o-sparkles')
                        ->schema([
                            Forms\Components\Repeater::make('highlights')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('label')
                                            ->required()
                                            ->columnSpan(2),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0),
                                    ]),
                                ])
                                ->orderColumn('sort_order')
                                ->addActionLabel('Add highlight')
                                ->collapsible()
                                ->defaultItems(0)
                                ->columnSpanFull(),
                        ]),

                    // ───────── Media ─────────
                    Forms\Components\Tabs\Tab::make('Media')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\FileUpload::make('cover_image')
                                ->label('Cover Image')
                                ->image()
                                ->directory('projects/covers')
                                ->disk('public')
                                ->visibility('public')
                                ->preserveFilenames(false)
                                ->maxSize(5120)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->imagePreviewHeight('200')
                                ->columnSpanFull(),

                            Forms\Components\Repeater::make('images')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\FileUpload::make('path')
                                            ->label('Image')
                                            ->image()
                                            ->directory('projects/gallery')
                                            ->disk('public')
                                            ->visibility('public')
                                            ->preserveFilenames(false)
                                            ->maxSize(5120)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->imagePreviewHeight('200')
                                            ->required()
                                            ->columnSpan(2),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0),
                                    ]),
                                ])
                                ->orderColumn('sort_order')
                                ->addActionLabel('Add gallery image')
                                ->collapsible()
                                ->defaultItems(0)
                                ->columnSpanFull(),
                        ]),

                    // ───────── Videos ─────────
                    Forms\Components\Tabs\Tab::make('Videos')
                        ->icon('heroicon-o-video-camera')
                        ->schema([
                            Forms\Components\Repeater::make('videos')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\Select::make('type')
                                            ->options([
                                                'youtube' => 'YouTube',
                                                'vimeo' => 'Vimeo',
                                                'mp4' => 'Uploaded MP4',
                                            ])
                                            ->default('youtube')
                                            ->required()
                                            ->native(false)
                                            ->live(),

                                        Forms\Components\TextInput::make('title')
                                            ->maxLength(255)
                                            ->placeholder('Optional — e.g. Project walkthrough'),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                    Forms\Components\TextInput::make('video_url')
                                        ->label('Video URL')
                                        ->helperText('Paste a full YouTube or Vimeo URL. ID is extracted automatically.')
                                        ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                                        ->required(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                            $type = $get('type');
                                            if ($state && $type) {
                                                $set('video_id', ProjectVideo::extractVideoId($state, $type));
                                            }
                                        })
                                        ->columnSpanFull(),

                                    Forms\Components\TextInput::make('video_id')
                                        ->label('Video ID (auto-extracted)')
                                        ->readOnly()
                                        ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                                        ->columnSpanFull(),

                                    Forms\Components\FileUpload::make('video_path')
                                        ->label('Upload video file (MP4)')
                                        ->visible(fn(Get $get) => $get('type') === 'mp4')
                                        ->required(fn(Get $get) => $get('type') === 'mp4')
                                        ->directory('projects/videos')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->preserveFilenames(false)
                                        ->acceptedFileTypes(['video/mp4', 'video/webm'])
                                        ->maxSize(51200)
                                        ->columnSpanFull(),

                                    Forms\Components\FileUpload::make('thumbnail_path')
                                        ->label('Thumbnail image')
                                        ->image()
                                        ->directory('projects/videos/thumbnails')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->preserveFilenames(false)
                                        ->maxSize(5120)
                                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                        ->imagePreviewHeight('200')
                                        ->helperText('Optional — falls back to YouTube thumbnail or project cover.')
                                        ->columnSpanFull(),

                                    Forms\Components\Toggle::make('is_published')
                                        ->default(true),
                                ])
                                ->orderColumn('sort_order')
                                ->addActionLabel('Add video')
                                ->collapsible()
                                ->defaultItems(0)
                                ->columnSpanFull(),
                        ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn($query) => $query
                    ->with(['country'])
                    ->withCount(['unitTypes', 'videos'])
            )
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->circular(false)
                    ->height(48)
                    ->width(64),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'ongoing',
                        'success' => 'completed',
                        'info' => 'off_plan',
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'off_plan' => 'Off-Plan',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                Tables\Columns\TextColumn::make('unitTypes_count')
                    ->label('Units')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('videos_count')
                    ->label('Videos')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('country_id')
                    ->label('Country')
                    ->relationship('country', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'off_plan' => 'Off-Plan',
                    ]),

                Tables\Filters\SelectFilter::make('location')
                    ->options(fn() => Project::whereNotNull('location')
                        ->distinct()
                        ->orderBy('location')
                        ->pluck('location', 'location')
                        ->toArray()),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}