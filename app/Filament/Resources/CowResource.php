<?php

namespace App\Filament\Resources;

use App\Enums\CowStatus;
use App\Filament\Resources\CowResource\Pages;
use App\Filament\Resources\CowResource\RelationManagers;
use App\Models\Cow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CowResource extends Resource
{
    protected static ?string $model = Cow::class;
    protected static ?string $label = 'Vaca';
    protected static ?string $navigationIcon = 'phosphor-cow';
    protected static ?string $navigationGroup = 'Menu Principal';
    protected static ?int $navigationSort = 2;

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
                            ->searchable()
                            ->required(),
                        Forms\Components\ToggleButtons::make('status')
                            ->options(CowStatus::class)
                            ->inline()
                            ->default(CowStatus::OK)
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\FileUpload::make('cow_photos')
                            ->label('Fotos')
                            ->maxFiles(3)
                            ->directory('cows')
                            ->disk('public')
                            ->image()
                            ->multiple()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Data de Nascimento')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('weight')
                    ->label('Peso (KG)')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('race')
                    ->label('Raça')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('farm.name')
                    ->label('Fazenda')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('collar.name')
                    ->label('Coleira')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('collar.status')
                    ->label('Status da Coleira')
                    ->sortable()
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado Em')
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado Em')
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('info'),
                    Tables\Actions\EditAction::make()->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
