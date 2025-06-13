<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;
use Filament\Forms;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Model;
use App\Enums\VisitStatusEnum;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms\Components\Section;
use App\Models\Organization;
use App\Models\User;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Visit::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Visit::query()
            ->whereBetween('visit_date', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['organization', 'user'])
            ->get()
            ->map(function (Visit $visit) {
                return EventData::make()
                    ->id($visit->id)
                    ->title($visit->organization->name ?? 'Visit')
                    ->start($visit->visit_date)
                    ->end($visit->visit_date)
                    ->backgroundColor(VisitStatusEnum::colors()[$visit->status] ?? '#6b7280');
            })
            ->toArray();
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    // dd($data);
                    return $data;
                }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    return $data;
                })
                ->visible(function (Visit $visit, ?Model $record) {
                    $originalStatus = $record->getOriginal('status') ?? $record->status;

                    return !in_array($originalStatus, ['visited', 'not-visited', 'canceled']);
                }),
            Actions\DeleteAction::make(),
        ];
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
        return [
            Forms\Components\Grid::make(2)
                ->schema([
                    Forms\Components\DatePicker::make('visit_date')
                        ->required()
                        ->label(__('Visit Date'))
                        ->default(now())
                        ->minDate(now()->startOfDay()) // No se pueden agendar citas antes de hoy
                        ->disabled(function (callable $get, ?Model $record) {
                            $status = $get('status');

                            // Si estamos creando, solo desactivar cuando esté en RESCHEDULED
                            if (!$record) {
                                return $status === 'rescheduled';
                            }

                            // Si estamos editando, verificar el estado original
                            $originalStatus = $record->getOriginal('status') ?? $record->status;

                            // Desactivado si el estado original era de los finales O si el estado actual es RESCHEDULED
                            return in_array($originalStatus, ['visited', 'not-visited', 'canceled']) || $status === 'rescheduled' || !$record->rescheduled_date || in_array($status, ['visited', 'not-visited', 'canceled', '']);
                        }),
                    Forms\Components\DatePicker::make('rescheduled_date')
                        ->label(__('Rescheduled Date'))
                        ->nullable()
                        ->minDate(now()->startOfDay()) // No se pueden agendar citas antes de hoy
                        ->visible(function (callable $get, ?Model $record) {
                            if ($record) {
                                return ($record->rescheduled_date || $get('status') === 'rescheduled');
                            }
                        })
                        ->required(fn(callable $get) => $get('status') === 'rescheduled'),
                ]),
            Forms\Components\Select::make('status')
                ->label(__('Status'))
                ->live()
                ->options(function (callable $get, callable $set, ?Model $record) {
                    $allOptions = VisitStatusEnum::keyValuesCombined();

                    // Si estamos creando, mostrar todas las opciones
                    if (!$record) {
                        unset($allOptions['rescheduled']);
                        return $allOptions;
                    }

                    $originalStatus = $record->getOriginal('status') ?? $record->status;

                    if ($originalStatus === 'rescheduled') {
                        unset($allOptions['scheduled']);
                    }

                    return $allOptions;
                })
                ->default('scheduled')
                ->required()
                ->disabled(function (callable $get, ?Model $record) {
                    // Si estamos creando, nunca desactivar
                    if (!$record) {
                        return false;
                    }

                    // Si estamos editando, verificar el estado original
                    $originalStatus = $record->getOriginal('status') ?? $record->status;

                    // Desactivado si el estado original era VISITED, NOT_VISITED o CANCELED
                    return in_array($originalStatus, ['visited', 'not-visited', 'canceled']);
                }),

            Forms\Components\Select::make('organization_id')
                ->label(__('Organization'))
                ->relationship('organization', 'name')
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
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
                })
                ->required()
                ->disabled(function (callable $get, ?Model $record) {
                    // Si estamos creando, nunca desactivar
                    if (!$record) {
                        return false;
                    }

                    $actualStatus = $get('status');

                    // Si estamos editando, verificar el estado original
                    $originalStatus = $record->getOriginal('status') ?? $record->status;

                    return in_array($originalStatus, ['rescheduled']) || in_array($actualStatus, ['visited', 'not-visited', 'canceled', 'rescheduled']);
                }),

            Forms\Components\Select::make('user_id')
                ->label(__('Assigned User'))
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
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
                })
                ->required()
                ->disabled(function (callable $get, ?Model $record) {
                    // Si estamos creando, nunca desactivar
                    if (!$record) {
                        return false;
                    }

                    $actualStatus = $get('status');

                    // Si estamos editando, verificar el estado original
                    $originalStatus = $record->getOriginal('status') ?? $record->status;

                    return in_array($originalStatus, ['rescheduled']) || in_array($actualStatus, ['visited', 'not-visited', 'canceled']);
                }),
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

            Forms\Components\Section::make(__('Contact Information'))
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([

                            Forms\Components\Fieldset::make(__('Organization Information'))
                                ->schema([
                                    Forms\Components\TextInput::make('organization.name')
                                        ->label(__('Organization Name'))
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->formatStateUsing(function (callable $get) {
                                            $userId = $get('user_id');
                                            if ($userId) {
                                                return User::find($userId)?->name;
                                            }
                                            return null;
                                        }),
                                    Forms\Components\TextInput::make('organization.email')
                                        ->label(__('Organization Email'))
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->formatStateUsing(function (callable $get) {
                                            $userId = $get('user_id');
                                            if ($userId) {
                                                return User::find($userId)?->email;
                                            }
                                            return null;
                                        }),
                                    Forms\Components\TextInput::make('organization.cellphone')
                                        ->label(__('Organization Cellphone'))
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->formatStateUsing(function (callable $get) {
                                            $userId = $get('user_id');
                                            if ($userId) {
                                                return User::find($userId)?->cellphone;
                                            }
                                            return null;
                                        }),
                                    Forms\Components\Textarea::make('organization.address')
                                        ->label(__('Organization Address'))
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->formatStateUsing(function (callable $get) {
                                            $organizationId = $get('organization_id');
                                            if ($organizationId) {
                                                return Organization::find($organizationId)?->addresses->first()?->fullAddress;
                                            }
                                            return null;
                                        })
                                        ->rows(2),
                                ]),

                            Forms\Components\Fieldset::make(__('Seller Information'))
                                ->schema([
                                    Forms\Components\TextInput::make('user.name')
                                        ->label(__('Seller Name'))
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->formatStateUsing(function (callable $get) {
                                            $userId = $get('user_id');
                                            if ($userId) {
                                                return User::find($userId)?->name;
                                            }
                                            return null;
                                        }),
                                    Forms\Components\TextInput::make('user.email')
                                        ->label(__('Seller Email'))
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->formatStateUsing(function (callable $get) {
                                            $userId = $get('user_id');
                                            if ($userId) {
                                                return User::find($userId)?->email;
                                            }
                                            return null;
                                        }),
                                    Forms\Components\TextInput::make('user.cellphone')
                                        ->label(__('Seller Cellphone'))
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->formatStateUsing(function (callable $get) {
                                            $userId = $get('user_id');
                                            if ($userId) {
                                                return User::find($userId)?->cellphone;
                                            }
                                            return null;
                                        }),
                                ]),
                        ]),
                ])
                ->collapsed(),
        ];
    }
}
