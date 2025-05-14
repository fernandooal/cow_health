<?php

namespace App\Filament\Resources\TemperatureDataResource\Pages;

use App\Filament\Resources\TemperatureDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemperatureData extends ListRecords
{
    protected static string $resource = TemperatureDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
