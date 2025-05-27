<?php

namespace App\Filament\Resources\CowResource\Widgets;

use App\Models\Cow;
use App\Models\Farm;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CowsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    protected function getStats(): array
    {
        $cowsByFarm = Farm::withCount('cows')
            ->orderBy('cows_count', 'desc')
            ->first();

        return [
            Stat::make('Total de vacas com colar', Cow::whereNotNull('collar_id')->count() ?? 0)
                ->color('primary')
                ->icon('phosphor-cow')
                ->description('Vacas cadastradas no sistema que possuem um colar vinculado.'),
            Stat::make('Vacas em atenção', Cow::where('status', '<>', 'ok')->count() ?? 0)
                ->color('warning')
                ->icon('heroicon-o-exclamation-triangle')
                ->description('Vacas cadastradas no sistema que precisam de qualquer tipo de atenção'),
            Stat::make('Fazenda com o maior número de vacas', $cowsByFarm->cows_count ?? 'Nenhuma vaca cadastrada')
                ->description('Fazenda: ' . ($cowsByFarm->name ?? 'Nenhuma vaca cadastrada'))
                ->color('success')
                ->icon('heroicon-o-shopping-bag'),
        ];
    }
}
