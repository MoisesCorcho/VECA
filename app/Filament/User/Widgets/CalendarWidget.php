<?php

namespace App\Filament\User\Widgets;

use Filament\Forms;
use App\Models\Visit;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Filament\Widgets\BaseCalendarWidget;
use App\Filament\User\Pages\SurveyResponsePage;

class CalendarWidget extends BaseCalendarWidget
{
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
                ->color('warning')
                ->action(function ($record) {
                    return redirect()->to(SurveyResponsePage::getUrlWithSurvey($record->user->assignedSurvey));
                })
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
}
