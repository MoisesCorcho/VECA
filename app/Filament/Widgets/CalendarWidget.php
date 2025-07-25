<?php

namespace App\Filament\Widgets;

use App\Models\Visit;
use App\Services\VisitService;
use Filament\Notifications\Notification;
use App\Exceptions\VisitStatusValidationException;
use Saade\FilamentFullCalendar\Actions\EditAction;
use Saade\FilamentFullCalendar\Actions\CreateAction;

class CalendarWidget extends BaseCalendarWidget
{
    public function getVisitServiceProperty()
    {
        return app(VisitService::class);
    }

    protected function getEventsQuery()
    {
        return Visit::query();
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
        return true;
    }

    protected function shouldShowOrganizationField(): bool
    {
        return true;
    }

    protected function shouldShowUserField(): bool
    {
        return true;
    }

    protected function shouldShowContactInformation(): bool
    {
        return true;
    }

    protected function getAdditionalFields(): array
    {
        return [];
    }

    protected function getAdditionalModalActions(): array
    {
        return [];
    }

    protected function beforeCreate(CreateAction $action, array $data): void
    {
        $visit = new Visit($data);

        try {
            $this->visitService->validateNewVisit($visit);
        } catch (VisitStatusValidationException $e) {
            Notification::make()->danger()->title('Validation Error')->body($e->getMessage())->send();

            $action->halt();
        }
    }

    protected function beforeEdit(EditAction $action, array $data): void
    {
        $visit = $action->getRecord()->fill($data);

        try {
            $this->visitService->validateVisitUpdate($visit);
        } catch (VisitStatusValidationException $e) {
            Notification::make()->danger()->title('Validation Error')->body($e->getMessage())->send();

            $action->halt();
        }
    }
}
