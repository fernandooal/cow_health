<?php

namespace App\Enums;

use App\Enums\Permissions\AreaPermissions;
use App\Enums\Permissions\AtivoPermissions;
use App\Enums\Permissions\CategoriaPermissions;
use App\Enums\Permissions\CentroResultadoPermissions;
use App\Enums\Permissions\FornecedorPermissions;
use App\Enums\Permissions\GrupoPermissions;
use App\Enums\Permissions\MovimentacaoPermissions;
use App\Enums\Permissions\MovimentacaoSoftwarePermissions;
use App\Enums\Permissions\ResponsavelPermissions;
use App\Enums\Permissions\SoftwarePermissions;
use App\Enums\Permissions\UserPermissions;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum TipoPermissions: string implements HasColor, HasLabel
{
    case User = 'user';

    public function getLabel(): string
    {
        return match ($this) {
            self::User => 'Usuário',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::User => 'info',
        };
    }

    public static function fromValue(string $value): self
    {
        return match ($value) {
            'user' => self::User,
            default => throw new InvalidArgumentException("Invalid value: $value"),
        };
    }

    public function getEnumClass()
    {
        return match ($this) {
            self::User => UserPermissions::class,
        };
    }
}
