<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;
use Filament\Forms;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;
use App\Enums\VisitStatusEnum;
use Saade\FilamentFullCalendar\Data\EventData;
use App\Models\Organization;
use App\Models\User;
use App\Helpers\FilamentHelpers;
use App\Helpers\Filament\CommonFormInputs;

abstract class BaseCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Visit::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return $this->getEventsQuery()
            ->whereBetween('visit_date', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['organization', 'user'])
            ->get()
            ->map(function (Visit $visit) {
                return EventData::make()
                    ->id($visit->id)
                    ->title($visit->organization->name ?? 'Visit')
                    ->start($visit->visit_date)
                    ->end($visit->visit_date)
                    ->backgroundColor(VisitStatusEnum::colors()[$visit->status->value] ?? '#6b7280');
            })
            ->toArray();
    }

    protected function headerActions(): array
    {
        $actions = [];

        if ($this->canCreate()) {
            $actions[] = Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    return $this->mutateCreateFormData($data);
                });
        }

        return $actions;
    }

    protected function modalActions(): array
    {
        $actions = [];

        if ($this->canEdit()) {
            $actions[] = Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    return $this->mutateEditFormData($data);
                })
                ->visible(function (Visit $visit, ?Model $record) {
                    return $this->isEditVisible($visit, $record);
                });
        }

        if ($this->canDelete()) {
            $actions[] = Actions\DeleteAction::make();
        }

        $actions = array_merge($actions, $this->getAdditionalModalActions());

        return $actions;
    }

    public function config(): array
    {
        return [
            'displayEventTime' => false,
            'dayMaxEvents' => true,
        ];
    }

    public function getFormSchema(): array
    {
        $schema = [];

        $schema[] = $this->getBasicFieldsGrid();

        $schema[] = $this->getStatusField();

        if ($this->shouldShowOrganizationField()) {
            $schema[] = $this->getOrganizationField();
        }

        if ($this->shouldShowUserField()) {
            $schema[] = $this->getUserField();
        }

        $schema = array_merge($schema, $this->getNonVisitFields());

        if ($this->shouldShowContactInformation()) {
            $schema[] = $this->getContactInformationSection();
        }

        $schema = array_merge($schema, $this->getAdditionalFields());

        return $schema;
    }

    // Abstract methots that must be implemented by child classes
    abstract protected function getEventsQuery();
    abstract protected function canCreate(): bool;
    abstract protected function canEdit(): bool;
    abstract protected function canDelete(): bool;
    abstract protected function shouldShowOrganizationField(): bool;
    abstract protected function shouldShowUserField(): bool;
    abstract protected function shouldShowContactInformation(): bool;
    abstract protected function getAdditionalFields(): array;
    abstract protected function getAdditionalModalActions(): array;

    // Methods that can be overridden
    protected function mutateCreateFormData(array $data): array
    {
        return $data;
    }

    protected function mutateEditFormData(array $data): array
    {
        return $data;
    }

    protected function isEditVisible(Visit $visit, ?Model $record): bool
    {
        $originalStatus = $record->getOriginal('status') ?? $record->status;
        return !in_array($originalStatus->value, ['visited', 'not-visited', 'canceled']);
    }

    protected function getBasicFieldsGrid()
    {
        return Forms\Components\Grid::make(2)
            ->schema([
                Forms\Components\DatePicker::make('visit_date')
                    ->required()
                    ->label(__('Visit Date'))
                    ->default(now())
                    ->minDate(now()->startOfDay())
                    ->disabled($this->getVisitDateDisabledCondition()),

                Forms\Components\DatePicker::make('rescheduled_date')
                    ->label(__('Rescheduled Date'))
                    ->nullable()
                    ->minDate(now()->startOfDay())
                    ->visible(function (callable $get, ?Model $record) {
                        if ($record) {
                            return ($record->rescheduled_date || $get('status') === 'rescheduled');
                        }
                    })
                    ->required(fn(callable $get) => $get('status') === 'rescheduled'),
            ]);
    }

    protected function getStatusField()
    {
        return Forms\Components\Select::make('status')
            ->label(__('Status'))
            ->live()
            ->options(fn(callable $get, callable $set, ?Model $record) => $this->getStatusOptions($get, $set, $record))
            ->default(VisitStatusEnum::SCHEDULED->value)
            ->required()
            ->disabled($this->getStatusDisabledCondition());
    }

    protected function getOrganizationField()
    {
        return Forms\Components\Select::make('organization_id')
            ->label(__('Organization'))
            ->relationship('organization', 'name')
            ->searchable()
            ->preload()
            ->live()
            ->afterStateUpdated(function ($state, callable $set) {
                $this->updateOrganizationFields($state, $set);
            })
            ->required()
            ->disabled($this->getOrganizationDisabledCondition());
    }

    protected function getUserField()
    {
        return Forms\Components\Select::make('user_id')
            ->label(__('Assigned User'))
            ->relationship('user', 'name')
            ->searchable()
            ->preload()
            ->live()
            ->afterStateUpdated(function ($state, callable $set) {
                $this->updateUserFields($state, $set);
            })
            ->required()
            ->disabled($this->getUserDisabledCondition());
    }

    protected function getNonVisitFields(): array
    {
        return [
            Forms\Components\Select::make('non_visit_reason_id')
                ->label(__('Non Visit Reason'))
                ->relationship('nonVisitReason', 'reason')
                ->searchable()
                ->preload()
                ->visible(fn(callable $get) => in_array($get('status'), ['canceled', 'not-visited']))
                ->required(fn(callable $get) => in_array($get('status'), ['canceled', 'not-visited'])),

            Forms\Components\Textarea::make('non_visit_description')
                ->label(__('Non Visit Description'))
                ->rows(3)
                ->visible(fn(callable $get) => in_array($get('status'), ['canceled', 'not-visited']))
                ->required(fn(callable $get) => in_array($get('status'), ['canceled', 'not-visited'])),
        ];
    }

    protected function getContactInformationSection()
    {
        return Forms\Components\Section::make(__('Contact Information'))
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Fieldset::make(__('Organization Information'))
                            ->schema($this->getOrganizationInfoFields()),

                        Forms\Components\Fieldset::make(__('Seller Information'))
                            ->schema($this->getSellerInfoFields()),
                    ]),
            ])
            ->collapsed();
    }

    protected function getOrganizationInfoFields(): array
    {
        return [
            CommonFormInputs::displayOnlyTextInput(
                'organization.name',
                __('Organization Name'),
                CommonFormInputs::getEntityFormatter(Organization::class, 'organization_id', 'name')
            ),
            CommonFormInputs::displayOnlyTextInput(
                'organization.email',
                __('Organization Email'),
                CommonFormInputs::getEntityFormatter(Organization::class, 'organization_id', 'email')
            ),
            CommonFormInputs::displayOnlyTextInput(
                'organization.cellphone',
                __('Organization Cellphone'),
                CommonFormInputs::getEntityFormatter(Organization::class, 'organization_id', 'cellphone')
            ),
            CommonFormInputs::displayOnlyTextInput(
                'organization.address',
                __('Organization Address'),
                function (callable $get) {
                    $organizationId = $get('organization_id');
                    if ($organizationId) {
                        return Organization::find($organizationId)?->addresses->first()?->fullAddress;
                    }
                    return null;
                }
            ),
        ];
    }

    protected function getSellerInfoFields(): array
    {
        return [
            CommonFormInputs::displayOnlyTextInput(
                'user.name',
                __('Seller Name'),
                CommonFormInputs::getEntityFormatter(User::class, 'user_id', 'name')
            ),
            CommonFormInputs::displayOnlyTextInput(
                'user.email',
                __('Seller Email'),
                CommonFormInputs::getEntityFormatter(User::class, 'user_id', 'email')
            ),
            CommonFormInputs::displayOnlyTextInput(
                'user.cellphone',
                __('Seller Cellphone'),
                CommonFormInputs::getEntityFormatter(User::class, 'user_id', 'cellphone')
            ),
        ];
    }

    protected function getVisitDateDisabledCondition()
    {
        return FilamentHelpers::shouldDisable(
            disabledOnOriginalStatuses: [VisitStatusEnum::VISITED, VisitStatusEnum::NOT_VISITED, VisitStatusEnum::CANCELED, VisitStatusEnum::SCHEDULED],
            disabledOnCurrentStatuses: [VisitStatusEnum::VISITED->value, VisitStatusEnum::NOT_VISITED->value, VisitStatusEnum::CANCELED->value, VisitStatusEnum::RESCHEDULED->value, ''],
        );
    }

    protected function getStatusDisabledCondition()
    {
        return FilamentHelpers::shouldDisable(
            disabledOnOriginalStatuses: ['visited', 'not-visited', 'canceled']
        );
    }

    protected function getOrganizationDisabledCondition()
    {
        return FilamentHelpers::shouldDisable(
            disabledOnOriginalStatuses: ['rescheduled'],
            disabledOnCurrentStatuses: ['visited', 'not-visited', 'canceled', 'rescheduled'],
        );
    }

    protected function getUserDisabledCondition()
    {
        return FilamentHelpers::shouldDisable(
            disabledOnOriginalStatuses: ['rescheduled'],
            disabledOnCurrentStatuses: ['visited', 'not-visited', 'canceled'],
        );
    }

    protected function getStatusOptions(callable $get, callable $set, ?Model $record): array
    {
        return collect(VisitStatusEnum::keyValuesCombined())
            ->when(!$record, fn($collection) => $collection->forget('rescheduled'))
            ->when($record && $record->getOriginal('status') === 'rescheduled', fn($collection) => $collection->forget('scheduled'))
            ->all();
    }

    protected function updateOrganizationFields($state, callable $set): void
    {
        $set('organization.name', null);
        $set('organization.email', null);
        $set('organization.phone', null);
        $set('organization.cellphone', null);
        $set('organization.address', null);

        if ($state) {
            $organization = Organization::find($state);
            if ($organization) {
                $set('organization.name', $organization->name);
                $set('organization.email', $organization->email);
                $set('organization.phone', $organization->phone);
                $set('organization.cellphone', $organization->cellphone);
                $set('organization.address', $organization->addresses->first()?->fullAddress);
            }
        }
    }

    protected function updateUserFields($state, callable $set): void
    {
        $set('user.name', null);
        $set('user.email', null);
        $set('user.cellphone', null);

        if ($state) {
            $user = User::find($state);
            if ($user) {
                $set('user.name', $user->name);
                $set('user.email', $user->email);
                $set('user.cellphone', $user->cellphone);
            }
        }
    }
}
