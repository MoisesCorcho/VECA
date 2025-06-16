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
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\CheckboxList;
use App\Models\Organization;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use App\Helpers\Filament\CommonColumns;
use App\Helpers\Filament\CommonFormInputs;
use App\Models\Survey;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationLabel(): string
    {
        return __('Sellers');
    }

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
                                CommonFormInputs::idTypeSelect('dni_type', 'ID Type'),
                                CommonFormInputs::identificationNumber('dni', 'ID Number', 'Enter ID number'),
                            ]),
                    ]),

                // Contact Information
                Forms\Components\Section::make('Contact Information')
                    ->description('Communication details')
                    ->collapsible()
                    ->schema([
                        CommonFormInputs::email('email', 'Email', 'example@domain'),
                        CommonFormInputs::phoneNumber('cellphone', 'Phone Number', 'Enter phone number'),
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

                        Forms\Components\Select::make('survey_id')
                            ->label('Survey')
                            ->options(Survey::query()->active()->pluck('title', 'id'))
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CommonColumns::baseTextColumn('full_name', 'Full Name')
                    ->searchable(['name', 'last_name']),

                CommonColumns::baseIconCopyableTextColumn('email', 'Email Address', 'heroicon-o-envelope'),
                CommonColumns::baseIconCopyableTextColumn('cellphone', 'Cellphone', 'heroicon-o-phone'),
                CommonColumns::baseTextColumn('dni_type', 'ID Type')
                    ->badge(),

                CommonColumns::baseIconCopyableTextColumn('dni', 'ID Number', 'heroicon-o-identification'),
                Tables\Columns\ToggleColumn::make('active')
                    ->sortable(),

                Tables\Columns\TextColumn::make('visits_per_day')
                    ->numeric()
                    ->sortable(),

                CommonColumns::createdAt()
                    ->label('Registered On'),
                CommonColumns::updatedAt()
                    ->label('Last Updated'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('manageOrganizations')
                        ->icon('heroicon-o-home-modern')
                        ->label('Manage Organizations')
                        ->color('secondary')
                        ->mountUsing(function (Form $form, User $record) {
                            $form->fill([
                                'organizations' => $record->organizations->pluck('id')->toArray(),
                            ]);
                        })
                        ->steps([
                            Step::make('Select Organization')
                                ->schema([
                                    CheckboxList::make('organizations')
                                        ->options(Organization::query()->pluck('name', 'id'))
                                        ->columns(4)
                                        ->searchable()
                                        ->bulkToggleable(),
                                ]),
                            Step::make('Review Changes')
                                ->schema([
                                    Placeholder::make('warning')
                                        ->content(function (Get $get): HtmlString {
                                            $selectedOrganizations = $get('organizations') ?? [];

                                            $affectedUsers = User::query()
                                                ->whereHas('organizations', function ($query) use ($selectedOrganizations) {
                                                    $query->whereIn('organizations.id', $selectedOrganizations);
                                                })
                                                ->get();

                                            $orgs = Organization::whereIn('id', $selectedOrganizations)->pluck('name')->toArray();

                                            $orgList = '';
                                            foreach ($orgs as $orgName) {
                                                $orgList .= '<li>' . e($orgName) . '</li>';
                                            }

                                            $userList = '';
                                            foreach ($affectedUsers as $user) {
                                                $userList .= '<li>' . e($user->full_name) . '</li>';
                                            }

                                            return new HtmlString(
                                                '<div class="text-warning-500 font-bold">Please be extremely careful with this action!</div>' .
                                                    '<p class="mt-2">By confirming, the following will occur:</p>' .
                                                    '<ul class="list-disc list-inside pl-6 mt-1">' .
                                                    '<li>All currently selected organizations will be <span class="font-semibold text-warning-500">disassociated</span> from their existing sellers.</li>' .
                                                    '<li>These selected organizations will then be <span class="font-semibold text-primary-500">assigned</span> to the current seller.</li>' .
                                                    '</ul>' .
                                                    '<p class="mt-2">You selected the following organizations:</p>' .
                                                    '<ul class="list-disc list-inside pl-8 text-sm text-gray-500">' .
                                                    $orgList .
                                                    '</ul>' .
                                                    '<p class="mt-2 text-warning-700">This change will affect the following sellers:</p>' .
                                                    '<ul class="list-disc list-inside pl-8 text-sm text-gray-500">' .
                                                    $userList .
                                                    '</ul>' .
                                                    '<p class="mt-2 text-warning-700 font-semibold">Proceed with extreme caution!</p>'
                                            );
                                        })
                                        ->columnSpanFull(),
                                ]),
                        ])
                        ->action(function (array $data, User $record): void {
                            Organization::query()->where('user_id', $record->id)->update(['user_id' => null]);
                            Organization::query()->whereIn('id', $data['organizations'])->update(['user_id' => $record->id]);

                            Notification::make()
                                ->title('Organizations successfully assigned!')
                                ->success()
                                ->send();
                        })
                        ->slideOver(),
                    Tables\Actions\ViewAction::make()
                        ->color('info'),
                    Tables\Actions\EditAction::make()
                        ->color('warning'),
                    Tables\Actions\DeleteAction::make()
                        ->color('danger')
                        ->requiresConfirmation()
                        ->preventDeletionWithRelated('organizations'),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
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
