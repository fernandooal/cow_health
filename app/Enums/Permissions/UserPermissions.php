<?php

namespace App\Enums\Permissions;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum UserPermissions: string implements HasColor, HasIcon, HasLabel
{
    case ViewAnyUser = 'ViewAny User';
    case ViewUser = 'View User';
    case CreateUser = 'Create User';
    case UpdateUser = 'Update User';
    case DeleteUser = 'Delete User';

    public function getLabel(): string
    {
        return match ($this) {
            self::ViewAnyUser => 'Acessar tela de Usuários',
            self::ViewUser => 'Visualizar dados de Usuários',
            self::CreateUser => 'Criar Usuário',
            self::UpdateUser => 'Atualizar Usuário',
            self::DeleteUser => 'Deletar Usuário',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ViewAnyUser => 'info',
            self::ViewUser => 'warning',
            self::CreateUser => 'success',
            self::UpdateUser => 'primary',
            self::DeleteUser => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ViewAnyUser => 'heroicon-m-book-open',
            self::ViewUser => 'heroicon-m-eye',
            self::CreateUser => 'heroicon-m-plus-circle',
            self::UpdateUser => 'heroicon-m-pencil',
            self::DeleteUser => 'heroicon-m-trash',
        };
    }

    public static function FromValue(string $value): self
    {
        return match($value){
            '0' => self::ViewAnyUser,
            '1' => self::ViewUser,
            '2' => self::CreateUser,
            '3' => self::UpdateUser,
            '4' => self::DeleteUser,
            default => throw new InvalidArgumentException("Valor inválido para UserPermissions: $value"),
        };
    }

    public static function fromLabel(string $label): self
    {
        return match ($label) {
            'ViewAny User' => self::ViewAnyUser,
            'View User' => self::ViewUser,
            'Create User' => self::CreateUser,
            'Update User' => self::UpdateUser,
            'Delete User' => self::DeleteUser,
            default => throw new InvalidArgumentException("Label inválido para UserPermissions: $label"),
        };
    }
}
