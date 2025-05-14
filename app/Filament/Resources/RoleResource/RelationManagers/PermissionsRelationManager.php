<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Enums\Permissions\UserPermissions;
use App\Enums\TipoPermissions;
use App\Enums\UserPerfil;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class PermissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'permissions';
    protected static ?string $icon = 'heroicon-o-key';
    protected static ?string $title='Permissões';
    protected static ?string $label='Permissão';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated([5,10, 25, 50, 100])
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->formatStateUsing(function ($state){

                        $enumCases = [
                            UserPermissions::cases(),
                        ];

                        foreach ($enumCases as $cases) {
                            foreach ($cases as $case) {
                                if ($case->value === $state) {
                                    return $case->getLabel();
                                }
                            }
                        }
                        return $state;
                    })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('vincular')
                    ->color("gray")
                    ->form([
                        Forms\Components\Select::make('tipoModel')
                            ->label('Recurso')
                            ->options(
                                TipoPermissions::class
                            )
                            ->required()
                            ->reactive()
                            ->live(),

                        Forms\Components\Select::make('tipoPermission')
                            ->label('Permissão')
                            ->visible(function (Get $get) {
                                return $get('tipoModel') !== null;
                            })
                            ->options(function (Get $get){
                                $value = $get('tipoModel');
                                return TipoPermissions::fromValue($value)->getEnumClass();
                            })
                            ->disableOptionWhen(function ($value) {
                                $grupoPermissions = $this->ownerRecord->permissions;
                                $names = [];
                                foreach ($grupoPermissions as $grupoPermission) {
                                    $names[] = $grupoPermission->name;
                                }
                                return in_array($value, $names);
                            })
                            ->multiple(),
                    ])
                    ->action(function ($data) {
                        try{
                            $role = $this->ownerRecord;
                            $dataSelect = $data['tipoPermission'];
                            $listPermission=[];
                            foreach ($dataSelect as $permission) {
                                $permissionByName = Permission::findByName($permission);
                                $listPermission[]=$permissionByName->id;
                            }
                            $role->permissions()->attach($listPermission);
                            $role->save();
                            Notification::make()
                                ->icon('heroicon-o-check')
                                ->iconColor('success')
                                ->title('Associado com sucesso!')
                                ->send();
                        }catch (\Exception $exception){
                            Log::error($exception->getMessage());
                            Notification::make()
                                ->icon('heroicon-o-x-mark')
                                ->iconColor('danger')
                                ->title('Falha ao associar, tente novamente mais tarde!')
                                ->send();
                        }

                    })
                    ->visible(function () {
                        $papel = $this->ownerRecord;
                        if( $papel->id == 1 or $papel->id == 2) {
                            $user = auth()->user()->perfil;
                            return $user !== UserPerfil::Admin;
                        }
                        return true;
                    })

            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->color('secondary')
                    ->visible(function () {
                        $papel = $this->ownerRecord;
                        if( $papel->id == 1 or $papel->id == 2) {
                            $user = auth()->user()->perfil;
                            return $user !== UserPerfil::Admin;
                        }
                        return true;
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->color('secondary')
                        ->visible(function () {
                            $papel = $this->ownerRecord;
                            if( $papel->id == 1 or $papel->id == 2) {
                                $user = auth()->user()->perfil;
                                return $user !== UserPerfil::Admin;
                            }
                            $papel->save();
                            return true;
                        })
                ])

            ]);
    }
}
