<?php

namespace App\Filament\Widgets;

use App\Models\Visit;

class CalendarWidget extends BaseCalendarWidget
{
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
}
