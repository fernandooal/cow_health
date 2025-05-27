<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum CollarStatus: string implements HasIcon, HasLabel, HasColor
{
    case OK = 'ok';
    case Manutencao = 'manutencao';
    case Bateria = 'bateria';
    case Inativo = 'inativo';

    public function getLabel(): string
    {
        return match ($this) {
            self::OK => 'OK',
            self::Manutencao => 'Necessita de Manutenção',
            self::Bateria => 'Bateria Fraca',
            self::Inativo => 'Inativo'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::OK => 'heroicon-o-check-badge',
            self::Manutencao => 'heroicon-o-wrench-screwdriver',
            self::Bateria => 'heroicon-o-battery-50',
            self::Inativo => 'heroicon-o-x-circle'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::OK => 'success',
            self::Manutencao => 'warning',
            self::Bateria => 'danger',
            self::Inativo => 'inative'
        };
    }

    public static function fromValue(string $value): static
    {
        return match ($value) {
            'ok' => self::OK,
            'manutencao' => self::Manutencao,
            'bateria' => self::Bateria,
            'inativo' => self::Inativo,
            default => throw new InvalidArgumentException("Invalid status value: {$value}"),
        };
    }
}
