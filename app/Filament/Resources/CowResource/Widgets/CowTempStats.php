<?php

namespace App\Filament\Resources\CowResource\Widgets;

use App\Models\Cow;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class CowTempStats extends ChartWidget
{
    public ?Cow $record = null;

    protected static ?string $heading = 'Histórico de Temperatura Corporal da Última Semana';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        if (!$this->record) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $temperatures = $this->record->temperatureDatas()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get()
            ->groupBy(fn ($item) => Carbon::parse($item->created_at)->toDateString())
            ->map(fn (Collection $group) => round($group->avg('temperature'), 2));

        $labels = [];
        $data = [];

        foreach ($temperatures as $date => $avgTemperature) {
            $labels[] = Carbon::parse($date)->format('d/m');
            $data[] = $avgTemperature;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Temperatura (ºC)',
                    'data' => $data,
                    'borderColor' => 'rgb(255, 99, 132)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
