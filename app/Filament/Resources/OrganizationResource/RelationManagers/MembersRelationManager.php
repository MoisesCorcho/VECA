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
use App\Helpers\Filament\CommonColumns;
use App\Helpers\Filament\CommonFormInputs;

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
                                CommonFormInputs::idTypeSelect('dni_type', 'ID Type'),
                                CommonFormInputs::identificationNumber('dni', 'ID Number', 'Enter ID number'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                DatePicker::make('birthdate')
                                    ->label('Birth Date')
                                    ->required()
                                    ->displayFormat('M d, Y')
                                    ->beforeOrEqual(now()->subYears(18))
                                    ->placeholder('Select date'),

                                CommonFormInputs::email('email', 'Email Address', 'john.doe@example.com'),
                            ]),
                    ]),

                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                CommonFormInputs::phoneNumber('cellphone_1', 'Primary Mobile Phone', 'Enter phone number'),
                                CommonFormInputs::phoneNumber('cellphone_2', 'Secondary Mobile Phone', 'Enter phone number')
                                    ->nullable(),
                            ]),

                        CommonFormInputs::phoneNumber('phone', 'Landline Phone', 'Enter phone number')
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
                CommonColumns::baseTextColumn('full_name', 'Full Name')
                    ->searchable(['first_name', 'last_name']),

                CommonColumns::baseTextColumn('dni_type', 'ID Type')
                    ->badge(),
                CommonColumns::baseIconCopyableTextColumn('dni', 'ID Number', 'heroicon-o-identification'),
                CommonColumns::baseIconCopyableTextColumn('email', 'Email Address', 'heroicon-o-envelope'),
                CommonColumns::baseIconCopyableTextColumn('cellphone_1', 'Cellphone', 'heroicon-o-phone'),
                CommonColumns::baseTextColumn('memberPosition.name', 'Position'),

                TextColumn::make('birthdate')
                    ->label('Birth Date')
                    ->date('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                CommonColumns::createdAt()
                    ->label('Registered On'),
                CommonColumns::updatedAt()
                    ->label('Last Updated'),
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
