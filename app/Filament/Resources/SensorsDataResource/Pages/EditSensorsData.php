<?php

namespace App\Filament\Resources\SensorsDataResource\Pages;

use App\Filament\Resources\SensorsDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSensorsData extends EditRecord
{
    protected static string $resource = SensorsDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
