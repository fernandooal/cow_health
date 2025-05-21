<?php

namespace App\Enums;

use App\Enums\Permissions\CollarPermissions;
use App\Enums\Permissions\CowPermissions;
use App\Enums\Permissions\FarmPermissions;
use App\Enums\Permissions\UserPermissions;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum TipoPermissions: string implements HasColor, HasLabel
{
    case User = 'user';
    case Cow = 'cow';
    case Farm = 'farm';
    case Collar = 'collar';

    public function getLabel(): string
    {
        return match ($this) {
            self::User => 'Usuário',
            self::Cow => 'Vaca',
            self::Farm => 'Fazenda',
            self::Collar => 'Colar'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::User => 'info',
            self::Cow => 'info',
            self::Farm => 'info',
            self::Collar => 'info',
        };
    }

    public static function fromValue(string $value): self
    {
        return match ($value) {
            'user' => self::User,
            'cow' => self::Cow,
            'farm' => self::Farm,
            'collar' => self::Collar,
            default => throw new InvalidArgumentException("Invalid value: $value"),
        };
    }

    public function getEnumClass()
    {
        return match ($this) {
            self::User => UserPermissions::class,
            self::Cow => CowPermissions::class,
            self::Farm => FarmPermissions::class,
            self::Collar => CollarPermissions::class,
        };
    }
}
