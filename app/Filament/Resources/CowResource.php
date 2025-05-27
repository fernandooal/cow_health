<?php

namespace App\Filament\Resources;

use App\Enums\CowStatus;
use App\Filament\Resources\CowResource\Pages;
use App\Filament\Resources\CowResource\RelationManagers;
use App\Models\Cow;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CowResource extends Resource
{
    protected static ?string $model = Cow::class;
    protected static ?string $label = 'Vaca';
    protected static ?string $navigationIcon = 'phosphor-cow';
    protected static ?string $navigationGroup = 'Menu Principal';
    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dados da Vaca')
                    ->description('Preencha os detalhes da vaca.')
                    ->icon('phosphor-cow')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Data de Nascimento')
                            ->required(),
                        Forms\Components\TextInput::make('weight')
                            ->label('Peso')
                            ->helperText('Peso em KG')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('race')
                            ->label('Raça')
                            ->required(),
                        Forms\Components\Select::make('farm_id')
                            ->label('Fazenda')
                            ->relationship('farm', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('collar_id')
                            ->label('Coleira')
                            ->relationship('collar', 'name')
                            ->searchable(),
                        Forms\Components\ToggleButtons::make('status')
                            ->options(CowStatus::class)
                            ->inline()
                            ->default(CowStatus::OK)
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\FileUpload::make('cow_photos')
                            ->label('Fotos')
                            ->directory('cows')
                            ->disk('public')
                            ->image()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('cow_photos')
                        ->height('100%')
                        ->width('100%'),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('name')
                            ->weight('bold'),
                        Tables\Columns\TextColumn::make('status')
                            ->limit(30),
                        Tables\Columns\TextColumn::make('race')
                            ->color('gray')
                            ->limit(30),
                        Tables\Columns\TextColumn::make('farm.name')
                            ->color('gray')
                            ->limit(30),
                    ]),
                ])->space(3),
                Tables\Columns\Layout\Panel::make([
                    Tables\Columns\TextColumn::make('birth_date')
                        ->formatStateUsing(fn ($state) => 'Data de Nascimento: ' . Carbon::parse($state)->format('d M Y'))
                        ->grow(false),
                    Tables\Columns\TextColumn::make('weight')
                        ->formatStateUsing(fn ($state) => 'Kg: ' . Carbon::parse($state)->format('KG'))
                        ->grow(false),
                    Tables\Columns\TextColumn::make('collar.name')
                        ->formatStateUsing(fn ($state) => 'Coleira: ' . $state)
                        ->label('Coleira'),
                ])->collapsible(),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->paginated([9, 24, 49, 99])
            ->actions([
                Tables\Actions\ViewAction::make()->color('info'),
                Tables\Actions\EditAction::make()->color('primary'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TemperatureRelationManager::class,
            RelationManagers\HeartRateRelationManager::class,
            RelationManagers\AccelerometerRelationManager::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'farm.name', 'collar.name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->farm->name . ' - ' . $record->name;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCows::route('/'),
//            'create' => Pages\CreateCow::route('/create'),
            'view' => Pages\ViewCow::route('/{record}'),
//            'edit' => Pages\EditCow::route('/{record}/edit'),
        ];
    }
}
