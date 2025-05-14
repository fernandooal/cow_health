<?php

namespace App\Filament\Resources\RoleResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $icon = 'heroicon-o-users';
    protected static ?string $title='Usuários';
    protected static ?string $label='Usuário';

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
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->multiple()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name', 'email'])
                    ->action(function (AttachAction $action) {
                        $data = $action->getFormData();
                        $users = User::whereIn('id', $data['recordId'])->get();
                        $role = $this->ownerRecord->name;

                        foreach ($users as $user) {
                            $user->syncRoles([$role]);
                        }

                        Notification::make()
                            ->icon('heroicon-o-check')
                            ->iconColor('success')
                            ->title('Ação realizada com sucesso!')
                            ->send();

                    })

            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->color('secondary')
                    ->visible(function ($record) {
                        if ($record->id != 1) {
                            return true;
                        }
                        return false;
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make()
                        ->color('secondary')
                        ->action(function ($records) {
                            $success = false;
                            foreach ($records as $record) {
                                if ( $record->id == 1) {
                                    Notification::make()
                                        ->icon('heroicon-o-x-mark')
                                        ->iconColor('danger')
                                        ->title('Não é permitido remover a permisão do administrador')
                                        ->send();

                                    continue;
                                }

                                $record->removeRole($this->ownerRecord);
                                $success = true;

                            }

                            if ($success) {
                                Notification::make()
                                    ->icon('heroicon-o-check')
                                    ->iconColor('success')
                                    ->title('Ação realizada com sucesso!')
                                    ->send();
                            }
                        }),
                ]),
            ]);
    }
}
