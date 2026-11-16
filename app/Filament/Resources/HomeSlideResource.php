<?php
namespace App\Filament\Resources;

use App\Filament\Resources\HomeSlideResource\Pages;
use App\Models\HomeSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomeSlideResource extends Resource
{
    protected static ?string $model = HomeSlide::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Home Slides';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Type')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->options([
                            'image' => 'Image',
                            'youtube' => 'YouTube Video',
                            'vimeo' => 'Vimeo Video',
                        ])
                        ->required()
                        ->native(false)
                        ->live(),
                ]),

            Forms\Components\Section::make('Content')
                ->schema([
                    Forms\Components\TextInput::make('title')->maxLength(255),
                    Forms\Components\Textarea::make('subtitle')->rows(2)->columnSpanFull(),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('cta_label')
                            ->label('Button label')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('cta_url')
                            ->label('Button URL')
                            ->maxLength(500)
                            ->placeholder('/kenya or https://...'),
                    ]),
                ]),

            Forms\Components\Section::make('Media')
                ->schema([
                    // IMAGE
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Image')
                        ->image()
                        ->directory('home-slides')
                        ->maxSize(5120) // 5 MB
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->imagePreviewHeight('200')
                        ->visible(fn(Get $get) => $get('type') === 'image')
                        ->required(fn(Get $get) => $get('type') === 'image'),

                    // VIDEO
                    Forms\Components\TextInput::make('video_url')
                        ->label('Video URL')
                        ->helperText('Paste a full YouTube or Vimeo URL. ID is extracted automatically.')
                        ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                        ->required(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo']))
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Get $get, Set $set, $state) {
                            $type = $get('type');
                            if ($state && $type) {
                                $set('video_id', HomeSlide::extractVideoId($state, $type));
                            }
                        }),

                    Forms\Components\TextInput::make('video_id')
                        ->label('Video ID (auto-extracted)')
                        ->readOnly()
                        ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo'])),

                    Forms\Components\FileUpload::make('poster_path')
                        ->label('Poster image (video fallback)')
                        ->image()
                        ->directory('home-slides/posters')
                        ->maxSize(5120)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->helperText('Shown before the video loads, and on slow connections.')
                        ->visible(fn(Get $get) => in_array($get('type'), ['youtube', 'vimeo'])),
                ]),
            Forms\Components\Section::make('Visibility')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_active')->default(true),
                    Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Preview')
                    ->height(50)
                    ->width(80)
                    ->defaultImageUrl(fn(HomeSlide $record) => $record->poster_path
                        ? asset('storage/' . $record->poster_path)
                        : null),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors(['gray' => 'image', 'danger' => 'youtube', 'info' => 'vimeo']),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('subtitle')->limit(40)->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->numeric(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\SelectFilter::make('type')
                    ->options(['image' => 'Image', 'youtube' => 'YouTube', 'vimeo' => 'Vimeo']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomeSlides::route('/'),
            'create' => Pages\CreateHomeSlide::route('/create'),
            'edit' => Pages\EditHomeSlide::route('/{record}/edit'),
        ];
    }
}