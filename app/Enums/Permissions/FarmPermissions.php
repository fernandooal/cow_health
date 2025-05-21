<?php

namespace App\Enums\Permissions;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum FarmPermissions: string implements HasColor, HasIcon, HasLabel
{
    case ViewAnyFarm = 'ViewAny Farm';
    case ViewFarm = 'View Farm';
    case CreateFarm = 'Create Farm';
    case UpdateFarm = 'Update Farm';
    case DeleteFarm = 'Delete Farm';

    public function getLabel(): string
    {
        return match ($this) {
            self::ViewAnyFarm => 'Acessar tela de Fazendas',
            self::ViewFarm => 'Visualizar dados de Fazendas',
            self::CreateFarm => 'Criar Fazenda',
            self::UpdateFarm => 'Atualizar Fazenda',
            self::DeleteFarm => 'Deletar Fazenda',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ViewAnyFarm => 'info',
            self::ViewFarm => 'warning',
            self::CreateFarm => 'success',
            self::UpdateFarm => 'primary',
            self::DeleteFarm => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ViewAnyFarm => 'heroicon-m-book-open',
            self::ViewFarm => 'heroicon-m-eye',
            self::CreateFarm => 'heroicon-m-plus-circle',
            self::UpdateFarm => 'heroicon-m-pencil',
            self::DeleteFarm => 'heroicon-m-trash',
        };
    }

    public static function FromValue(string $value): self
    {
        return match($value){
            '0' => self::ViewAnyFarm,
            '1' => self::ViewFarm,
            '2' => self::CreateFarm,
            '3' => self::UpdateFarm,
            '4' => self::DeleteFarm,
            default => throw new InvalidArgumentException("Valor inválido para FarmPermissions: $value"),
        };
    }

    public static function fromLabel(string $label): self
    {
        return match ($label) {
            'ViewAny Farm' => self::ViewAnyFarm,
            'View Farm' => self::ViewFarm,
            'Create Farm' => self::CreateFarm,
            'Update Farm' => self::UpdateFarm,
            'Delete Farm' => self::DeleteFarm,
            default => throw new InvalidArgumentException("Label inválido para FarmPermissions: $label"),
        };
    }
}
