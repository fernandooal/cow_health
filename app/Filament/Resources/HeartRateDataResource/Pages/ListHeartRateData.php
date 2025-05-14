<?php

namespace App\Filament\Resources\HeartRateDataResource\Pages;

use App\Filament\Resources\HeartRateDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeartRateData extends ListRecords
{
    protected static string $resource = HeartRateDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
