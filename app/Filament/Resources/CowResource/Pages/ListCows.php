<?php

namespace App\Filament\Resources\CowResource\Pages;

use App\Filament\Resources\CowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCows extends ListRecords
{
    protected static string $resource = CowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
