<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CalendarPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.pages.calendar-page';

    protected static ?string $title = 'Calendar';

    public static function getNavigationLabel(): string
    {
        return __('Calendar');
    }
}
