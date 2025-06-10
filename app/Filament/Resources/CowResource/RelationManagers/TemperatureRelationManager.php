<?php

namespace App\Filament\Resources\CowResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TemperatureRelationManager extends RelationManager
{
    protected static string $relationship = 'temperatureDatas';
    protected static ?string $title = 'Dados de Temperatura';
    protected static ?string $icon = 'phosphor-thermometer-hot-fill';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->paginated(['10', '25', '50', '100'])
            ->columns([
                Tables\Columns\TextColumn::make('temperature')
                    ->label('Temperatura Corporal')
                    ->formatStateUsing(fn ($state) => $state . ' °C')
                    ->sortable()
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
