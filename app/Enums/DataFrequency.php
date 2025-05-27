<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum DataFrequency: string implements HasLabel
{
    case Rapido = '2';
    case Padrao = '10';
    case Lento = '60';

    public function getLabel(): string
    {
        return match ($this) {
            self::Rapido => 'Modo Rápido - 2 minutos',
            self::Padrao => 'Modo Padrão - 10 minutos',
            self::Lento => 'Modo Lento - 60 minutos',
        };
    }

    public static function fromValue(string $value): static
    {
        return match ($value) {
            '2' => self::Rapido,
            '10' => self::Padrao,
            '60' => self::Lento,
            default => throw new InvalidArgumentException("Invalid status value: {$value}"),
        };
    }
}
