<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Blog Posts';
    protected static ?string $navigationGroup = 'Media';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Content')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()->maxLength(255)->live(onBlur: true)
                    ->afterStateUpdated(function (string $op, $state, Set $set) {
                        if ($op === 'create')
                            $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\TextInput::make('category')->placeholder('News, Market Update…'),
                    Forms\Components\TextInput::make('author_name')->placeholder('Author name'),
                    Forms\Components\DateTimePicker::make('published_at')->default(now()),
                ]),
                Forms\Components\Textarea::make('excerpt')->rows(3)->maxLength(500),
                Forms\Components\RichEditor::make('body')
                    ->fileAttachmentsDirectory('posts')->columnSpanFull(),
            ]),
            Forms\Components\Section::make('Media')->schema([
                Forms\Components\FileUpload::make('cover_image')
                    ->image()->directory('posts/covers')->maxSize(5120),
            ]),
            Forms\Components\Section::make('SEO')->schema([
                Forms\Components\TextInput::make('meta_title')->maxLength(255),
                Forms\Components\Textarea::make('meta_description')->rows(2)->maxLength(500),
            ]),
            Forms\Components\Section::make('Visibility')->columns(3)->schema([
                Forms\Components\Toggle::make('is_published')->default(true),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('cover_image')->height(40)->width(56),
            Tables\Columns\TextColumn::make('title')->searchable()->weight('semibold')->limit(50),
            Tables\Columns\TextColumn::make('category')->badge()->color('info'),
            Tables\Columns\TextColumn::make('author_name')->toggleable(),
            Tables\Columns\IconColumn::make('is_published')->boolean(),
            Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
        ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}