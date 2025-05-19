<?php

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('street')
                    ->label('Street Address')
                    ->required()
                    ->placeholder('123 Main St')
                    ->maxLength(100)
                    ->minLength(3),

                Grid::make()
                    ->schema([
                        TextInput::make('city')
                            ->label('City')
                            ->required()
                            ->placeholder('New York')
                            ->maxLength(100)
                            ->alpha(),

                        TextInput::make('state')
                            ->label('State/Province')
                            ->required()
                            ->placeholder('NY')
                            ->maxLength(100)
                            ->minLength(2)
                            ->alpha(),
                    ]),

                Grid::make()
                    ->schema([
                        TextInput::make('country')
                            ->label('Country')
                            ->required()
                            ->placeholder('United States')
                            ->maxLength(100)
                            ->alpha(),

                        TextInput::make('zip_code')
                            ->label('Postal/ZIP Code')
                            ->required()
                            ->placeholder('230001')
                            ->maxLength(20)
                            ->minLength(3)
                            ->numeric(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('street')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('city')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('state')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('country')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('zip_code')
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25);
    }
}
