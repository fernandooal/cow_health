<?php

namespace App\Filament\Resources\PermissionGroupResource\RelationManagers;

use App\Enums\Permissions\UserPermissions;
use App\Enums\TipoPermissions;
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
    protected static ?string $label = 'Permissão';
    protected static ?string $pluralLabel = 'Permissões';
    protected static ?string $title ='Permissões';
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('guard_name')
                    ->default('web')
                    ->hidden(True)
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->paginated([5,10, 25, 50, 100])
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('name')
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
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('guard_name')->label('Guard Name')->visible(false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Vincular')
                    ->color('gray')
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
                            ->multiple()
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
                                $names =[];
                                foreach ($grupoPermissions as $grupoPermission) {
                                    $names[]=$grupoPermission->name;
                                }
                                return in_array($value, $names);
                            }),
                    ])
                    ->action(function ($data) {
                        try{
                            $group = $this->ownerRecord;
                            $dataSelect = $data['tipoPermission'];
                            $listPermission=[];
                            foreach ($dataSelect as $permission) {
                                $permissionByName = Permission::findByName($permission);
                                $listPermission[]=$permissionByName->id;
                            }
                            $group->permissions()->attach($listPermission);
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

            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->color('secondary'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->color('secondary'),
                ]),
            ]);
    }

}
