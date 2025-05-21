<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Organization;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;
use App\Filament\Resources\OrganizationResource\RelationManagers\AddressesRelationManager;
use App\Filament\Resources\OrganizationResource\RelationManagers\MembersRelationManager;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function getNavigationGroup(): string
    {
        return __('Clients');
    }

    public static function getNavigationLabel(): string
    {
        return __('Organizations');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Organization Information')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Organization Name')
                                    ->placeholder('Enter organization name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->label('Assigned to Seller')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Brief description of the organization')
                            ->rows(3),
                    ]),

                // Contact Information
                Forms\Components\Section::make('Contact Information')
                    ->description('Communication details')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('nit')
                                    ->label('NIT')
                                    ->placeholder('Enter identification number')
                                    ->required(),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('contact@organization.com'),
                            ]),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('cellphone')
                                    ->label('Mobile Phone')
                                    ->tel()
                                    ->required()
                                    ->placeholder('+1 (555) 000-0000'),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Office Phone')
                                    ->tel()
                                    ->required()
                                    ->placeholder('+1 (555) 000-0000'),
                            ])
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cellphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Assigned to')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\BulkActionGroup::make([]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [
            MembersRelationManager::class,
            AddressesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'view' => Pages\ViewOrganization::route('/{record}'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
