<?php


namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum UserPerfil: string implements HasColor, HasIcon, HasLabel
{
    case Admin = '0';
    case Basic = '1';
    public function getLabel(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Basic => 'Básico',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Admin => 'info',
            self::Basic => 'warning'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Admin => 'heroicon-m-sparkles',
            self::Basic => 'heroicon-m-user-circle',
        };
    }
    public static function fromValue(string $value): self
    {
        return match ($value) {
            '0'=>self::Admin,
            '1'=>self::Basic,
            default => throw new InvalidArgumentException("Invalid status value: $value"),
        };
    }

}
