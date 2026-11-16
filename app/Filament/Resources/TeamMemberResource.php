<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Team Members';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')
                ->options(['board' => 'Board of Directors', 'management' => 'Management'])
                ->required()->native(false),
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('role')->maxLength(255),
            Forms\Components\FileUpload::make('photo')
                ->image()->directory('team')->imageEditor()->maxSize(5120),
            Forms\Components\TextInput::make('linkedin_url')->url()->maxLength(500),
            Forms\Components\Textarea::make('bio')->rows(4)->columnSpanFull(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('photo')->circular()->height(40)->width(40),
            Tables\Columns\TextColumn::make('name')->searchable()->weight('semibold'),
            Tables\Columns\TextColumn::make('role')->toggleable(),
            Tables\Columns\BadgeColumn::make('type')
                ->colors(['primary' => 'board', 'success' => 'management']),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->numeric(),
        ])
            ->defaultSort('type')->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(['board' => 'Board', 'management' => 'Management']),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}