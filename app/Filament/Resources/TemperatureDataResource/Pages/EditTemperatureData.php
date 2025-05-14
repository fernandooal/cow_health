<?php

namespace App\Filament\Resources\TemperatureDataResource\Pages;

use App\Filament\Resources\TemperatureDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTemperatureData extends EditRecord
{
    protected static string $resource = TemperatureDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
