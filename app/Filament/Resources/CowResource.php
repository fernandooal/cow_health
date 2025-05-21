<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CowResource\Pages;
use App\Filament\Resources\CowResource\RelationManagers;
use App\Models\Cow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CowResource extends Resource
{
    protected static ?string $model = Cow::class;
    protected static ?string $label = 'Vaca';
    protected static ?string $navigationIcon = 'phosphor-cow';
    protected static ?string $navigationGroup = 'Menu Principal';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\TextInput::make('race')
                    ->required(),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('cow_photos'),
                Forms\Components\Toggle::make('needs_treatment')
                    ->required(),
                Forms\Components\TextInput::make('farm_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('collar_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('needs_treatment')
                    ->boolean(),
                Tables\Columns\TextColumn::make('farm_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('collar_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCows::route('/'),
            'create' => Pages\CreateCow::route('/create'),
            'edit' => Pages\EditCow::route('/{record}/edit'),
        ];
    }
}
