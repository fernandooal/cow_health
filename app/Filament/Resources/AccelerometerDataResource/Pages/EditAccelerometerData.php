<?php

namespace App\Filament\Resources\AccelerometerDataResource\Pages;

use App\Filament\Resources\AccelerometerDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccelerometerData extends EditRecord
{
    protected static string $resource = AccelerometerDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
