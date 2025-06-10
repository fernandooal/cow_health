<?php

namespace App\Filament\Resources\CowResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class HeartRateRelationManager extends RelationManager
{
    protected static string $relationship = 'heartRateDatas';
    protected static ?string $title = 'Dados de Frequência Cardíaca';
    protected static ?string $icon = 'phosphor-heartbeat-fill';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->paginated(['10', '25', '50', '100'])
            ->columns([
                Tables\Columns\TextColumn::make('bpm')
                    ->label('Frequência Cardíaca')
                    ->formatStateUsing(fn ($state) => $state . ' BPM')
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
