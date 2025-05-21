<?php

namespace App\Enums\Permissions;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum CowPermissions: string implements HasColor, HasIcon, HasLabel
{
    case ViewAnyCow = 'ViewAny Cow';
    case ViewCow = 'View Cow';
    case CreateCow = 'Create Cow';
    case UpdateCow = 'Update Cow';
    case DeleteCow = 'Delete Cow';

    public function getLabel(): string
    {
        return match ($this) {
            self::ViewAnyCow => 'Acessar tela de Vacas',
            self::ViewCow => 'Visualizar dados de Vacas',
            self::CreateCow => 'Criar Vaca',
            self::UpdateCow => 'Atualizar Vaca',
            self::DeleteCow => 'Deletar Vaca',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ViewAnyCow => 'info',
            self::ViewCow => 'warning',
            self::CreateCow => 'success',
            self::UpdateCow => 'primary',
            self::DeleteCow => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ViewAnyCow => 'heroicon-m-book-open',
            self::ViewCow => 'heroicon-m-eye',
            self::CreateCow => 'heroicon-m-plus-circle',
            self::UpdateCow => 'heroicon-m-pencil',
            self::DeleteCow => 'heroicon-m-trash',
        };
    }

    public static function FromValue(string $value): self
    {
        return match($value){
            '0' => self::ViewAnyCow,
            '1' => self::ViewCow,
            '2' => self::CreateCow,
            '3' => self::UpdateCow,
            '4' => self::DeleteCow,
            default => throw new InvalidArgumentException("Valor inválido para CowPermissions: $value"),
        };
    }

    public static function fromLabel(string $label): self
    {
        return match ($label) {
            'ViewAny Cow' => self::ViewAnyCow,
            'View Cow' => self::ViewCow,
            'Create Cow' => self::CreateCow,
            'Update Cow' => self::UpdateCow,
            'Delete Cow' => self::DeleteCow,
            default => throw new InvalidArgumentException("Label inválido para CowPermissions: $label"),
        };
    }
}
