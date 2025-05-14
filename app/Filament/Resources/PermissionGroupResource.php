<?php

namespace App\Filament\Resources;

use App\Enums\UserPerfil;
use App\Filament\Resources\PermissionGroupResource\Pages;
use App\Filament\Resources\PermissionGroupResource\RelationManagers;
use App\Models\PermissionGroup;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PermissionGroupResource extends Resource
{
    protected static ?string $model = PermissionGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationGroup = 'Acessos';
    protected static ?string $navigationLabel = 'Grupos de Permissões';
    protected static ?string $label="Grupo de Permissões";
    protected static ?string $pluralLabel="Grupos de Permissões";
    protected static ?string $slug="grupo_permissoes";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descricao')
                    ->label('Descrição')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([5,10, 25, 50, 100])
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Criado em")
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label("Atualizado em")
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Conceder')
                    ->visible(function (){
                        $perfil = auth()->user()->perfil;
                        return  $perfil == UserPerfil::Admin;
                    })
                    ->color('secondary')
                    ->icon('heroicon-m-archive-box-arrow-down')
                    ->form([
                        Forms\Components\Section::make('Registro múltiplo de permissões')
                            ->description('Selecione os papéis que receberão todas as permissões cadastradas no grupo')
                            ->schema([
                                Select::make('perfis')
                                    ->label('Selecione os Papéis')
                                    ->multiple()
                                    ->options(function(){
                                        $user = auth()->user();
                                        if($user->hasRole('SuperAdmin')){
                                            return Role::all()->pluck('name', 'id');
                                        } else{
                                            return Role::all()->where('id', '!=', '1')->pluck('name', 'id');
                                        }
                                    })
                                    ->required(),
                            ])
                    ])
                    ->action(function (array $data,$record) {
                        $perfis = $data['perfis'];
                        $permissions = $record->permissions;
                        foreach ($perfis as $perfil) {
                            $perfilModel = Role::find($perfil);
                            $perfilModel->permissions()->syncWithoutDetaching($permissions);
                            $perfilModel->save();
                        }
                        Notification::make()
                            ->title('Aviso')
                            ->icon('heroicon-o-check')
                            ->iconColor('success')
                            ->body("Permissoes concedidas com sucesso!")
                            ->send();
                    })->requiresConfirmation(),
                Tables\Actions\Action::make('Revogar')
                    ->visible(function (){
                        $perfil = auth()->user()->perfil;
                        return  $perfil == UserPerfil::Admin;
                    })
                    ->color('danger')
                    ->icon('heroicon-m-archive-box-x-mark')
                    ->form([
                        Forms\Components\Section::make('Registro múltiplo de permissões')
                            ->description('Selecione os papéis que terão todas as permissões cadastradas no grupo revogadas')
                            ->schema([
                                Select::make('perfis')
                                    ->label('Selecione os Papéis')
                                    ->multiple()
                                    ->options(function(){
                                        $user = auth()->user();
                                        if($user->hasRole('SuperAdmin')){
                                            return Role::all()->pluck('name', 'id');
                                        } else{
                                            return Role::all()->where('id', '!=', '1')->pluck('name', 'id');
                                        }
                                    })
                                    ->required(),
                            ])
                    ])
                    ->action(function (array $data, $record) {
                        $perfis = $data['perfis'];
                        $permissions = $record->permissions;
                        foreach ($perfis as $perfil) {
                            $perfilModel = Role::findById($data['perfis'][0]);
                            $perfilModel->permissions()->detach($permissions);
                            $perfilModel->save();
                        }
                        Notification::make()
                            ->title('Aviso')
                            ->icon('heroicon-o-check')
                            ->iconColor('success')
                            ->body("Permissões removidas com sucesso!")
                            ->send();
                    })->requiresConfirmation()
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PermissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissionGroups::route('/'),
            'create' => Pages\CreatePermissionGroup::route('/create'),
            'edit' => Pages\EditPermissionGroup::route('/{record}/edit'),
        ];
    }

}
