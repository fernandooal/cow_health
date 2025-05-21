<?php

namespace App\Enums\Permissions;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum CollarPermissions: string implements HasColor, HasIcon, HasLabel
{
    case ViewAnyCollar = 'ViewAny Collar';
    case ViewCollar = 'View Collar';
    case CreateCollar = 'Create Collar';
    case UpdateCollar = 'Update Collar';
    case DeleteCollar = 'Delete Collar';

    public function getLabel(): string
    {
        return match ($this) {
            self::ViewAnyCollar => 'Acessar tela de Coleiras',
            self::ViewCollar => 'Visualizar dados de Coleiras',
            self::CreateCollar => 'Criar Coleira',
            self::UpdateCollar => 'Atualizar Coleira',
            self::DeleteCollar => 'Deletar Coleira',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ViewAnyCollar => 'info',
            self::ViewCollar => 'warning',
            self::CreateCollar => 'success',
            self::UpdateCollar => 'primary',
            self::DeleteCollar => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ViewAnyCollar => 'heroicon-m-book-open',
            self::ViewCollar => 'heroicon-m-eye',
            self::CreateCollar => 'heroicon-m-plus-circle',
            self::UpdateCollar => 'heroicon-m-pencil',
            self::DeleteCollar => 'heroicon-m-trash',
        };
    }

    public static function FromValue(string $value): self
    {
        return match($value){
            '0' => self::ViewAnyCollar,
            '1' => self::ViewCollar,
            '2' => self::CreateCollar,
            '3' => self::UpdateCollar,
            '4' => self::DeleteCollar,
            default => throw new InvalidArgumentException("Valor inválido para CollarPermissions: $value"),
        };
    }

    public static function fromLabel(string $label): self
    {
        return match ($label) {
            'ViewAny Collar' => self::ViewAnyCollar,
            'View Collar' => self::ViewCollar,
            'Create Collar' => self::CreateCollar,
            'Update Collar' => self::UpdateCollar,
            'Delete Collar' => self::DeleteCollar,
            default => throw new InvalidArgumentException("Label inválido para CollarPermissions: $label"),
        };
    }
}
