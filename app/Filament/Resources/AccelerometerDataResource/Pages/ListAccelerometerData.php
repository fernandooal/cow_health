<?php

namespace App\Filament\Resources\AccelerometerDataResource\Pages;

use App\Filament\Resources\AccelerometerDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccelerometerData extends ListRecords
{
    protected static string $resource = AccelerometerDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
