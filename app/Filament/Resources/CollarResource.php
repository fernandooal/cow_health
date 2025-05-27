<?php

namespace App\Filament\Resources;

use App\Enums\CollarStatus;
use App\Enums\DataFrequency;
use App\Filament\Resources\CollarResource\Pages;
use App\Filament\Resources\CollarResource\RelationManagers;
use App\Models\Collar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CollarResource extends Resource
{
    protected static ?string $model = Collar::class;
    protected static ?string $label = 'Colar';
    protected static ?string $pluralLabel = 'Colares';
    protected static ?string $navigationIcon = 'phosphor-belt';
    protected static ?string $navigationGroup = 'Menu Principal';
    protected static ?int $navigationSort = 1;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\ToggleButtons::make('status')
                    ->label('Status do Colar')
                    ->inline()
                    ->options(CollarStatus::class)
                    ->columnSpanFull()
                    ->default(CollarStatus::OK)
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Select::make('data_frequency')
                    ->label('Frequência de Dados')
                    ->options(DataFrequency::class)
                    ->helperText('Selecione a frequência do recebimento dos dados.')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(['10', '25', '50', '100'])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('data_frequency')
                    ->label('Frequência de Dados')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado Em')
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado Em')
                    ->dateTime('d M Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->color('primary'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'cow.name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->name;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollars::route('/'),
//            'create' => Pages\CreateCollar::route('/create'),
//            'edit' => Pages\EditCollar::route('/{record}/edit'),
        ];
    }
}
