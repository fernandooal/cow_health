<?php

namespace App\Filament\Resources\CowResource\Pages;

use App\Enums\CowStatus;
use App\Filament\Resources\CowResource;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewCow extends ViewRecord
{
    protected static string $resource = CowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('editar')
                ->label('Editar')
                ->icon('heroicon-o-pencil')
                ->url(fn () => static::getResource()::getUrl('edit', ['record' => $this->record->getKey()])),
        ];
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados da Vaca')
                    ->collapsible()
                    ->collapsed()
                    ->description('Visualize os detalhes da vaca selecionada.')
                    ->icon('phosphor-cow')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('birth_date')
                            ->label('Data de Nascimento')
                            ->required(),
                        TextInput::make('weight')
                            ->label('Peso')
                            ->helperText('Peso em KG')
                            ->required()
                            ->numeric(),
                        TextInput::make('race')
                            ->label('Raça')
                            ->required(),
                        Select::make('farm_id')
                            ->label('Fazenda')
                            ->relationship('farm', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('collar_id')
                            ->label('Coleira')
                            ->relationship('collar', 'name')
                            ->searchable()
                            ->required(),
                        ToggleButtons::make('status')
                            ->options(CowStatus::class)
                            ->inline()
                            ->default(CowStatus::OK)
                            ->columnSpanFull()
                            ->required(),
                        FileUpload::make('cow_photos')
                            ->label('Fotos')
                            ->maxFiles(3)
                            ->directory('cows')
                            ->disk('public')
                            ->image()
                            ->multiple()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CowResource\Widgets\CowHRStats::class,
            CowResource\Widgets\CowTempStats::class,
        ];
    }
}
