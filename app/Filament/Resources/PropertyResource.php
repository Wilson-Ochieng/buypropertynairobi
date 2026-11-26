<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use App\Models\PropertyVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Properties';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Property')->columnSpanFull()->tabs([

                Forms\Components\Tabs\Tab::make('Basic')->icon('heroicon-o-information-circle')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()->maxLength(255)->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if ($operation === 'create')
                                    $set('slug', Str::slug($state));
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()->maxLength(255)->unique(ignoreRecord: true),

                        Forms\Components\Select::make('country_id')
                            ->label('Country')->relationship('country', 'name')
                            ->searchable()->preload()->required(),

                        Forms\Components\Select::make('use_id')
                            ->label('Use category')->relationship('useCategory', 'name')
                            ->searchable()->preload(),

                        Forms\Components\Select::make('category')
                            ->options(['residential' => 'Residential', 'commercial' => 'Commercial', 'land' => 'Land'])
                            ->default('residential')->required()->native(false),

                        Forms\Components\Select::make('purpose')
                            ->options(['sale' => 'For Sale', 'rent' => 'For Rent', 'both' => 'Both'])
                            ->default('sale')->required()->native(false),

                        Forms\Components\Select::make('status')
                            ->options([
                                'available' => 'Available',
                                'sold' => 'Sold',
                                'rented' => 'Rented',
                                'off_plan' => 'Off-Plan',
                                'under_construction' => 'Under Construction',
                            ])
                            ->default('available')->required()->native(false),

                        Forms\Components\TextInput::make('property_type')
                            ->label('Property type')
                            ->placeholder('apartment, villa, townhouse, plot, office')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('bedrooms')->numeric()->minValue(0),
                        Forms\Components\TextInput::make('bathrooms')->numeric()->minValue(0),
                        Forms\Components\TextInput::make('floors')->numeric()->minValue(0),

                        Forms\Components\TextInput::make('size_sqm')
                            ->label('Size (m²)')->numeric()->step(0.01),

                        Forms\Components\TextInput::make('price_kes')
                            ->label('Price (KES)')->numeric()->prefix('KES')
                            ->helperText('Leave blank for "Price on request"'),

                        Forms\Components\Toggle::make('price_negotiable')->label('Price negotiable'),

                        Forms\Components\TextInput::make('location')
                            ->label('Location')->placeholder('Westlands, Nairobi')
                            ->required(),

                        Forms\Components\TextInput::make('city')->maxLength(255),

                        Forms\Components\TextInput::make('address')->maxLength(255)->columnSpanFull(),

                        Forms\Components\Textarea::make('description')->rows(8)->columnSpanFull(),

                        Forms\Components\TagsInput::make('features')
                            ->label('Features & amenities')
                            ->placeholder('Add feature and press Enter')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('contact_email')->email(),

                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('WhatsApp number')
                            ->placeholder('254710998888'),

                        Forms\Components\TextInput::make('latitude')->numeric()->step(0.0000001),
                        Forms\Components\TextInput::make('longitude')->numeric()->step(0.0000001),

                        Forms\Components\TextInput::make('sort_order')->numeric()->default(0),

                        Forms\Components\Toggle::make('is_featured')->label('Featured on homepage'),
                        Forms\Components\Toggle::make('is_published')->label('Published')->default(true),
                    ]),
                ]),

                Forms\Components\Tabs\Tab::make('Highlights')->icon('heroicon-o-sparkles')->schema([
                    Forms\Components\Repeater::make('highlights')->relationship()->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('label')->required()->columnSpan(2),
                            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                        ]),
                    ])
                        ->orderColumn('sort_order')
                        ->addActionLabel('Add highlight')
                        ->collapsible()->defaultItems(0)->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Media')->icon('heroicon-o-photo')->schema([
                    Forms\Components\FileUpload::make('cover_image')
                        ->label('Cover image')->image()->directory('properties/covers')
                        ->disk('public')->visibility('public')->preserveFilenames(false)
                        ->maxSize(5120)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->imagePreviewHeight('200')->columnSpanFull(),

                    Forms\Components\Repeater::make('images')->relationship()->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\FileUpload::make('path')
                                ->label('Image')->image()->directory('properties/gallery')
                                ->disk('public')->visibility('public')->preserveFilenames(false)
                                ->maxSize(5120)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->imagePreviewHeight('200')->required()->columnSpan(2),
                            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                        ]),
                    ])
                        ->orderColumn('sort_order')
                        ->addActionLabel('Add gallery image')
                        ->collapsible()->defaultItems(0)->columnSpanFull(),
                ]),

                Forms\Components\Tabs\Tab::make('Videos')->icon('heroicon-o-video-camera')->schema([
                    Forms\Components\Repeater::make('videos')->relationship()->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('type')
                                ->options(['youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'mp4' => 'Uploaded MP4'])
                                ->default('youtube')->required()->native(false)->live(),
                            Forms\Components\TextInput::make('title')->maxLength(255),
                            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                        ]),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                            ->required(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $type = $get('type');
                                if ($state && $type) {
                                    $set('video_id', PropertyVideo::extractVideoId($state, $type));
                                }
                            })
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('video_id')
                            ->label('Video ID (auto-extracted)')->readOnly()
                            ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('video_path')
                            ->label('Upload video (MP4)')
                            ->visible(fn(Get $get) => $get('type') === 'mp4')
                            ->required(fn(Get $get) => $get('type') === 'mp4')
                            ->directory('properties/videos')->disk('public')->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])->maxSize(51200)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('thumbnail_path')
                            ->label('Thumbnail')->image()->directory('properties/videos/thumbnails')
                            ->disk('public')->visibility('public')->preserveFilenames(false)
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->imagePreviewHeight('200')->columnSpanFull(),

                        Forms\Components\Toggle::make('is_published')->default(true),
                    ])
                        ->orderColumn('sort_order')
                        ->addActionLabel('Add video')
                        ->collapsible()->defaultItems(0)->columnSpanFull(),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($q) => $q->with(['country'])->withCount(['images', 'videos']))
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('Cover')
                    ->circular(false)->height(48)->width(64),

                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->weight('semibold'),

                Tables\Columns\TextColumn::make('country.name')->label('Country')->badge()->sortable(),

                Tables\Columns\TextColumn::make('location')->searchable()->sortable()->toggleable(),

                Tables\Columns\BadgeColumn::make('category')
                    ->colors(['success' => 'residential', 'warning' => 'commercial', 'info' => 'land']),

                Tables\Columns\BadgeColumn::make('purpose')
                    ->colors(['primary' => 'sale', 'success' => 'rent', 'gray' => 'both']),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'available',
                        'danger' => 'sold',
                        'gray' => 'rented',
                        'info' => 'off_plan',
                        'warning' => 'under_construction',
                    ]),

                Tables\Columns\TextColumn::make('price_kes')->label('Price')
                    ->money('KES', divideBy: 1)->sortable()->toggleable(),

                Tables\Columns\TextColumn::make('bedrooms')->numeric()->toggleable(),

                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Live'),

                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),

                Tables\Columns\TextColumn::make('images_count')->label('Images')->toggleable(),
                Tables\Columns\TextColumn::make('videos_count')->label('Videos')->toggleable(),

                Tables\Columns\TextColumn::make('sort_order')->numeric()->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('country_id')
                    ->label('Country')->relationship('country', 'name'),

                Tables\Filters\SelectFilter::make('category')
                    ->options(['residential' => 'Residential', 'commercial' => 'Commercial', 'land' => 'Land']),

                Tables\Filters\SelectFilter::make('purpose')
                    ->options(['sale' => 'For Sale', 'rent' => 'For Rent', 'both' => 'Both']),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'sold' => 'Sold',
                        'rented' => 'Rented',
                        'off_plan' => 'Off-Plan',
                        'under_construction' => 'Under Construction',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}