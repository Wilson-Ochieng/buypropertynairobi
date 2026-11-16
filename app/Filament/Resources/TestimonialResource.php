<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Testimonials';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Author')->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\TextInput::make('author_name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('author_role')
                        ->placeholder('e.g. Homeowner, Kilimani')
                        ->maxLength(255),

                    Forms\Components\Select::make('source')
                        ->options(['manual' => 'Manual', 'google' => 'Google Review'])
                        ->default('manual')
                        ->required()
                        ->native(false)
                        ->helperText('Google-sourced testimonials sync automatically and are usually read-only.'),

                    Forms\Components\FileUpload::make('author_photo')
                        ->label('Author photo')
                        ->image()
                        ->directory('testimonials/authors')
                        ->maxSize(2048),
                ]),
            ]),

            Forms\Components\Section::make('Review')->schema([
                Forms\Components\Textarea::make('quote')
                    ->label('Testimonial')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Select::make('rating')
                        ->options([1 => '1 star', 2 => '2 stars', 3 => '3 stars', 4 => '4 stars', 5 => '5 stars'])
                        ->default(5),

                    Forms\Components\TextInput::make('location')
                        ->placeholder('e.g. Kilimani, Nairobi'),

                    Forms\Components\Select::make('project_id')
                        ->label('Related project (optional)')
                        ->relationship('project', 'name')
                        ->searchable()
                        ->preload(),
                ]),
            ]),

            Forms\Components\Section::make('Visibility')->columns(3)->schema([
                Forms\Components\Toggle::make('is_featured')->label('Featured (shown first)'),
                Forms\Components\Toggle::make('is_published')->default(true),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('author_photo')
                    ->label('')
                    ->circular()
                    ->height(36)
                    ->width(36)
                    ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->author_name) . '&background=C09C7A&color=fff'),

                Tables\Columns\TextColumn::make('author_name')->searchable()->weight('semibold'),

                Tables\Columns\TextColumn::make('quote')->limit(60)->wrap(),

                Tables\Columns\TextColumn::make('rating')
                    ->formatStateUsing(fn($state) => str_repeat('★', (int) $state) . str_repeat('☆', 5 - (int) $state))
                    ->color('warning'),

                Tables\Columns\BadgeColumn::make('source')
                    ->colors(['gray' => 'manual', 'info' => 'google']),

                Tables\Columns\TextColumn::make('location')->toggleable(),

                Tables\Columns\IconColumn::make('is_featured')->boolean()->toggleable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('source')
                    ->options(['manual' => 'Manual', 'google' => 'Google']),
                Tables\Filters\TernaryFilter::make('is_published'),
                Tables\Filters\TernaryFilter::make('is_featured'),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}