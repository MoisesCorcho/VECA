<?php

namespace App\Filament\User\Widgets;

use Filament\Forms;
use App\Models\Visit;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Filament\Pages\SurveyResponse;
use App\Filament\Widgets\BaseCalendarWidget;

class CalendarWidget extends BaseCalendarWidget
{
    protected function getEventsQuery()
    {
        // User solo ve sus propias visitas
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
        return false; // Los usuarios no pueden eliminar visitas
    }

    protected function shouldShowOrganizationField(): bool
    {
        return true; // Los usuarios pueden seleccionar organizaciones
    }

    protected function shouldShowUserField(): bool
    {
        return false; // Se maneja internamente
    }

    protected function shouldShowContactInformation(): bool
    {
        return true;
    }

    protected function mutateCreateFormData(array $data): array
    {
        // Asignar automáticamente el usuario actual
        $data['user_id'] = Auth::id();
        return parent::mutateCreateFormData($data);
    }

    protected function mutateEditFormData(array $data): array
    {
        // Asegurar que no se cambie el usuario asignado
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
                ->icon('heroicon-m-x-mark')
                ->color('warning')
                ->action(function ($record) {
                    dd($record->user);
                    return redirect()->to(SurveyResponse::getUrlWithSurvey($record));
                })
        ];
    }

    // Sobrescribir sección de información de contacto para mostrar solo organización
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
