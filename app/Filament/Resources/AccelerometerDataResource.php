<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccelerometerDataResource\Pages;
use App\Filament\Resources\AccelerometerDataResource\RelationManagers;
use App\Models\AccelerometerData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AccelerometerDataResource extends Resource
{
    protected static ?string $model = AccelerometerData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sensors_data_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('gyro_x')
                    ->numeric(),
                Forms\Components\TextInput::make('gyro_y')
                    ->numeric(),
                Forms\Components\TextInput::make('gyro_z')
                    ->numeric(),
                Forms\Components\TextInput::make('accel_x')
                    ->numeric(),
                Forms\Components\TextInput::make('accel_y')
                    ->numeric(),
                Forms\Components\TextInput::make('accel_z')
                    ->numeric(),
                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sensors_data_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gyro_x')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gyro_y')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gyro_z')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accel_x')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accel_y')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('accel_z')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccelerometerData::route('/'),
            'create' => Pages\CreateAccelerometerData::route('/create'),
            'edit' => Pages\EditAccelerometerData::route('/{record}/edit'),
        ];
    }
}
