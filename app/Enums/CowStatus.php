<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum CowStatus: string implements HasIcon, HasLabel, HasColor
{
    case OK = 'ok';
    case Parto = 'parto';
    case Termico = 'termico';
    case Urgente = 'urgente';

    public function getLabel(): string
    {
        return match ($this) {
            self::OK => 'Saudável',
            self::Urgente => 'Atendimento Urgente',
            self::Parto => 'Parto Iminente',
            self::Termico => 'Estresse Térmico'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::OK => 'heroicon-o-check-badge',
            self::Urgente => 'heroicon-o-exclamation-triangle',
            self::Parto => 'phosphor-cow',
            self::Termico => 'heroicon-o-fire',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::OK => 'success',
            self::Urgente => 'danger',
            self::Parto => 'ternary',
            self::Termico => 'danger',
        };
    }

    public static function fromValue(string $value): static
    {
        return match ($value) {
            'ok' => self::OK,
            'urgente' => self::Urgente,
            'parto' => self::Parto,
            'termico' => self::Termico,
            default => throw new InvalidArgumentException("Invalid status value: {$value}"),
        };
    }
}
