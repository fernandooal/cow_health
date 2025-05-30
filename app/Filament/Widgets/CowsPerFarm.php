<?php

namespace App\Filament\Widgets;

use App\Models\Farm;
use Filament\Widgets\ChartWidget;

class CowsPerFarm extends ChartWidget
{
    protected static ?string $heading = 'Top 5 Fazendas com mais Vacas';
    protected static ?int $sort = 0;
    protected static string $color = 'danger';

    protected function getData(): array
    {
        $farms = Farm::withCount('cows')
            ->orderBy('cows_count', 'desc')
            ->take(5)
            ->get();

        $labels = [];
        $datasets = [];
        foreach ($farms as $farm) {
            $label = $farm->name;

            if(!in_array($label, $labels)){
                $labels[] = $label;
            }

            $datasets[$label] = [
                'label' => $label,
                'data' => array_fill(0, count($labels), 0),
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgb(255, 99, 132)',
                'borderWidth' => 1,
            ];
        }

        foreach($farms as $farm){
            $label = $farm->name;
            $index = array_search($label, $labels);
            $datasets[$label]['data'][$index] = $farm->cows_count;
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
            'indexAxis' => 'y',
            'responsive' => true,
        ];
    }
}
