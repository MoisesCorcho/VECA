<?php

namespace App\Filament\User\Widgets;

use Filament\Forms;
use App\Models\Visit;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Filament\Widgets\BaseCalendarWidget;
use App\Filament\User\Pages\SurveyResponsePage;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use App\Enums\VisitStatusEnum;
use App\Helpers\FilamentHelpers;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class CalendarWidget extends BaseCalendarWidget
{
    use HasWidgetShield;

    protected function getEventsQuery()
    {
        // User just can see their own visits
        return Visit::query()->where('user_id', Auth::id());
    }

    protected function canCreate(): bool
    {
        return true;
    }

    protected function canEdit(): bool
    {
        return true;
    }

    protected function canDelete(): bool
    {
        return false;
    }

    protected function shouldShowOrganizationField(): bool
    {
        return true;
    }

    protected function shouldShowUserField(): bool
    {
        return false;
    }

    protected function shouldShowContactInformation(): bool
    {
        return true;
    }

    protected function mutateCreateFormData(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['survey_id'] = Auth::user()->assignedSurvey?->id;
        return parent::mutateCreateFormData($data);
    }

    protected function mutateEditFormData(array $data): array
    {
        $data['user_id'] = Auth::id();
        return parent::mutateEditFormData($data);
    }

    protected function getAdditionalFields(): array
    {
        return [];
    }

    protected function getAdditionalModalActions(): array
    {
        return [
            Action::make('responseSurvey')
                ->icon('heroicon-m-newspaper')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading(__('Start Survey'))
                ->modalDescription(__('Are you sure you want to start the survey? The appointment status will be changed to "visited".'))
                ->modalSubmitActionLabel(__('Start Survey'))
                ->action(function ($record) {
                    if ($record->user && $record->user->assignedSurvey) {
                        return redirect()->to(SurveyResponsePage::getUrlWithSurvey($record->user->assignedSurvey, $record));
                    }

                    return Notification::make()
                        ->danger()
                        ->title('Error')
                        ->body('User does not have an assigned survey')
                        ->send();
                })
                ->visible(fn($record) => in_array($record->getOriginal('status'), [VisitStatusEnum::SCHEDULED, VisitStatusEnum::RESCHEDULED])),
        ];
    }

    protected function getContactInformationSection()
    {
        return Forms\Components\Section::make(__('Contact Information'))
            ->schema([
                Forms\Components\Fieldset::make(__('Organization Information'))
                    ->schema($this->getOrganizationInfoFields()),
            ])
            ->collapsed();
    }

    protected function getStatusField()
    {
        return Forms\Components\Select::make('status')
            ->label(__('Status'))
            ->live()
            ->options(fn(callable $get, callable $set, ?Model $record) => $this->getStatusOptions($get, $set, $record))
            ->default(VisitStatusEnum::SCHEDULED->value)
            ->required()
            ->disabled(fn($record) => !$record);
    }

    protected function getStatusOptions(callable $get, callable $set, ?Model $record): array
    {
        return collect(VisitStatusEnum::keyValuesCombined())
            ->when(!$record, fn($collection) => $collection->forget('rescheduled'))
            ->when($record && $record->getOriginal('status') === VisitStatusEnum::RESCHEDULED, fn($collection) => $collection->forget(['scheduled', 'visited']))
            ->when($record && $record->getOriginal('status') === VisitStatusEnum::SCHEDULED, fn($collection) => $collection->forget(['visited']))
            ->all();
    }

    protected function getOrganizationDisabledCondition()
    {
        return FilamentHelpers::shouldDisable(disableOnEdit: true);
    }
}
