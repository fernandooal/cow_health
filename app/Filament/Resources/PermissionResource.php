<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Acessos';
    protected static ?string $navigationLabel = 'Permissões';
    protected static ?string $label="Permissão";
    protected static ?string $pluralLabel="Permissões";
    protected static ?string $slug="permissao";

//    public static function shouldRegisterNavigation(): bool
//    {
//        return auth()->check() && auth()->user()->hasRole('SuperAdmin');
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('guard_name')
                    ->default('web')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([5,10, 25, 50, 100])
            ->groups([
                Group::make('permissionGroups.nome')
                    ->label('Grupos de Permissoes'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guard_name')
                    ->hidden()
                    ->label('Guard Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('permissionGroups.nome')
                    ->label('Grupo de Permissoes')
                    ->sortable(),
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
                SelectFilter::make('permissionGroups')
                    ->label('Grupos de Permissoes')
                    ->relationship('permissionGroups','nome')


            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
