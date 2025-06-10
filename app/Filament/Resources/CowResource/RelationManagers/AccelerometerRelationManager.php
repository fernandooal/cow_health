<?php

namespace App\Filament\Resources\CowResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AccelerometerRelationManager extends RelationManager
{
    protected static string $relationship = 'accelerometerDatas';
    protected static ?string $title = 'Dados de Movimentação';
    protected static ?string $icon = 'phosphor-sneaker-move-fill';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->paginated(['10', '25', '50', '100'])
            ->columns([
                Tables\Columns\TextColumn::make('gyro_x')
                    ->label('Giro X')
                    ->sortable()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('gyro_y')
                    ->label('Giro Y')
                    ->sortable()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('gyro_z')
                    ->label('Giro Z')
                    ->sortable()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('accel_x')
                    ->label('Acel X')
                    ->sortable()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('accel_y')
                    ->label('Acel Y')
                    ->sortable()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('accel_z')
                    ->label('Acel Z')
                    ->sortable()
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Medido Em')
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Recebido Em')
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ]);
    }
}
