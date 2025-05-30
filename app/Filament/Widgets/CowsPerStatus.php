<?php

namespace App\Filament\Widgets;

use App\Enums\CowStatus;
use App\Models\Cow;
use Filament\Widgets\ChartWidget;

class CowsPerStatus extends ChartWidget
{
    protected static ?string $heading = 'Vacas por Status';
    protected static ?int $sort = 1;
    protected static string $color = 'secondary';

    protected function getData(): array
    {
        $cows = Cow::all()->groupBy('status');

        $labels = [];
        $datasets = [];
        foreach ($cows as $status => $cow) {
            $label = CowStatus::fromValue($status)->getLabel();

            if(!in_array($label, $labels)){
                $labels[] = $label;
            }

            $datasets[$label] = [
                'label' => $label,
                'data' => array_fill(0, count($labels), 0),
                'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                'borderColor' => 'rgba(255, 159, 64)',
                'borderWidth' => 1,
            ];
        }

        foreach ($cows as $status => $cow) {
            $label = CowStatus::fromValue($status)->getLabel();
            $index = array_search($label, $labels);
            $datasets[$label]['data'][$index] = $cow->count();
        }

        $datasets = array_values($datasets);

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'datalabels' => [
                    'anchor' => 'end',
                    'align' => 'top',
                    'color' => '#000',
                    'font' => [
                        'weight' => 'bold',
                    ],
                    'formatter' => function ($value) {
                        return $value;
                    },
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                    'grid' => [
                        'color' => 'rgba(128, 128, 128, 0.3)',
                    ],
                ],
            ],
            'responsive' => true,
        ];
    }
}
