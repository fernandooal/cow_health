<?php

namespace App\Filament\Resources;

use App\Enums\UserPerfil;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Acessos';
    protected static ?string $label = "Usuário";
    protected static ?string $pluralLabel = 'Usuários';
    protected static ?string $slug = "usuario";

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('Identificação')
                        ->icon('heroicon-o-user-circle')
                        ->description('Dados de identificação e acesso do usuário')
                        ->schema([

                            Forms\Components\TextInput::make('name')
                                ->label('Nome')
                                ->disabled(function ($record) {
                                    if (isset($record)) {
                                        return $record->hasRole('SuperAdmin') && !auth()->user()->hasRole('SuperAdmin');
                                    }
                                })
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email')
                                ->disabledOn('edit')
                                ->email()
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('password')
                                ->disabled(function ($record) {
                                    if (isset($record)) {
                                        return $record->hasRole('SuperAdmin') ? true : false;
                                    }
                                })
                                ->password()
                                ->label('Senha')
                                ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : $state)
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $context): bool => $context === 'create')
                                ->maxLength(255),

                        ]),
                ]),
                Split::make([
                    Section::make('Configurações')
                        ->icon('heroicon-o-lock-closed')
                        ->description('Controle de acesso, alteração de perfil, acesso à centros de resultado ')
                        ->schema([
                            Forms\Components\Toggle::make('ativo')
                                ->disabled(function ($record) {
                                    if (isset($record)) {
                                        return $record->hasRole('SuperAdmin') && !auth()->user()->hasRole('SuperAdmin');
                                    }
                                    return false;
                                }),
                            Forms\Components\Select::make('perfil')
                                ->disabled(function ($record) {
                                    if (isset($record)) {
                                        return $record->hasRole('SuperAdmin') && !auth()->user()->hasRole('SuperAdmin');
                                    }
                                })
                                ->label('Perfil')
                                ->options(UserPerfil::class)
                                ->preload()
                                ->required(),
                            Forms\Components\Select::make('roles')
                                ->label('Papéis')
                                ->options(UserPerfil::class)
                                ->relationship('roles', 'name', modifyQueryUsing: function (Builder $query) {
                                    $user = auth()->user();
                                    if ($user->hasRole('SuperAdmin')) {
                                        return $query;
                                    }
                                    return $query->where('id', '!=', '1');
                                })
                                ->disabled(function ($record) {
                                    if (isset($record)) {
                                        return $record->hasRole('SuperAdmin') && !auth()->user()->hasRole('SuperAdmin');
                                    }
                                })
                                ->multiple()
                                ->preload()
                                ->required()
                        ]),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([5, 10, 25, 50, 100])
            ->columns([
                Tables\Columns\TextColumn::make('perfil')
                    ->label('Perfil')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Papéis')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\IconColumn::make('ativo')
                    ->alignCenter()
                    ->label('Acesso')
                    ->sortable()
                    ->boolean()
                    ->toggleable()
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
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
