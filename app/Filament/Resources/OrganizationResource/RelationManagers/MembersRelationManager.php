<?php

namespace App\Filament\Resources\OrganizationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Enums\DniType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('John'),

                                TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Doe'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('dni_type')
                                    ->label('ID Type')
                                    ->options(DniType::keyValuesCombined())
                                    ->default('CC')
                                    ->required(),

                                TextInput::make('dni')
                                    ->label('ID Number')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('1234567890')
                                    ->maxLength(20)
                                    ->numeric(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                DatePicker::make('birthdate')
                                    ->label('Birth Date')
                                    ->required()
                                    ->displayFormat('M d, Y')
                                    ->beforeOrEqual(now()->subYears(18))
                                    ->placeholder('Select date'),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('john.doe@example.com')
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('cellphone_1')
                                    ->label('Primary Mobile Phone')
                                    ->tel()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('+1 (555) 000-0000')
                                    ->maxLength(20)
                                    ->regex('/^[+\d\s()-]+$/'),

                                TextInput::make('cellphone_2')
                                    ->label('Secondary Mobile Phone')
                                    ->tel()
                                    ->placeholder('+1 (555) 000-0000')
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(20)
                                    ->regex('/^[+\d\s()-]+$/')
                                    ->nullable(),
                            ]),

                        TextInput::make('phone')
                            ->label('Landline Phone')
                            ->tel()
                            ->placeholder('+1 (555) 000-0000')
                            ->maxLength(20)
                            ->regex('/^[+\d\s()-]+$/')
                            ->nullable(),
                    ]),

                Section::make('Organization Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('member_position_id')
                                    ->label('Position')
                                    ->relationship('memberPosition', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(100),
                                        TextInput::make('description')
                                            ->maxLength(255),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('dni_type')
                    ->label('ID Type')
                    ->badge()
                    ->toggleable(),

                TextColumn::make('dni')
                    ->label('ID Number')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('cellphone_1')
                    ->label('Mobile Phone')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('memberPosition.name')
                    ->label('Position')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('birthdate')
                    ->label('Birth Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Registered On')
                    ->dateTime('M d, Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('member_position_id')
                    ->relationship('memberPosition', 'name')
                    ->label('Position')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('dni_type')
                    ->label('ID Type')
                    ->options(DniType::keyValuesCombined()),
            ])
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filters')
            )
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->defaultSort('created_at', 'desc');
    }
}
