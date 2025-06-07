<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class About extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'Sobre';
    protected static ?string $title = 'Sobre o projeto';
    protected static string $view = 'filament.pages.about';
}
