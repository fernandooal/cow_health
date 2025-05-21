<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum CowStatus: string implements HasIcon, HasLabel, HasColor
{
    case OK = 'ok';
    case Atencao = 'atencao';
    case Urgente = 'urgente';
    case Parto = 'parto';

    public function getLabel(): string
    {
        return match ($this) {
            self::OK => 'Saudável',
            self::Atencao => 'Necessita de Atenção',
            self::Urgente => 'Atendimento Urgente',
            self::Parto => 'Trabalho de Parto'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::OK => 'heroicon-o-check-badge',
            self::Atencao => 'heroicon-o-eye',
            self::Urgente => 'heroicon-o-exclamation-triangle',
            self::Parto => 'phosphor-cow',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::OK => 'success',
            self::Atencao => 'warning',
            self::Urgente => 'danger',
            self::Parto => 'ternary',
        };
    }

    public static function fromValue(string $value): static
    {
        return match ($value) {
            'ok' => self::OK,
            'atencao' => self::Atencao,
            'urgente' => self::Urgente,
            'parto' => self::Parto,
            default => throw new InvalidArgumentException("Invalid status value: {$value}"),
        };
    }
}
