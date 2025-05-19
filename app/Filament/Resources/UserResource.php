<?php

namespace App\Filament\Resources;

use App\Enums\DniType;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Personal Information - Main Section
                Forms\Components\Section::make('Personal Information')
                    ->description('Main user data')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->placeholder('Enter name'),
                                Forms\Components\TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->placeholder('Enter last name'),
                            ]),

                        // Identification
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('dni_type')
                                    ->label('ID Type')
                                    ->options(DniType::keyValuesCombined())
                                    ->searchable(),
                                Forms\Components\TextInput::make('dni')
                                    ->label('ID Number')
                                    ->maxLength(20),
                            ]),
                    ]),

                // Contact Information
                Forms\Components\Section::make('Contact Information')
                    ->description('Communication details')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->autocomplete()
                            ->placeholder('example@domain.com'),
                        Forms\Components\TextInput::make('cellphone')
                            ->label('Phone Number')
                            ->tel()
                            ->prefix('+')
                            ->placeholder('Enter number without spaces'),
                    ]),

                // Account Settings
                Forms\Components\Section::make('Account Settings')
                    ->description('Access settings and preferences')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(function (string $operation): bool {
                                return $operation === 'create';
                            })
                            ->dehydrated(fn($state) => filled($state))
                            ->minLength(8)
                            ->helperText('Minimum 8 characters'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('active')
                                    ->label('Active User')
                                    ->required()
                                    ->default(true),
                                Forms\Components\TextInput::make('visits_per_day')
                                    ->label('Visits Per Day')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(10)
                                    ->suffix('visits')
                                    ->helperText('Daily visits limit'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cellphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dni_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dni')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('visits_per_day')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->color('info'),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                        ->color('danger')
                        ->requiresConfirmation()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
