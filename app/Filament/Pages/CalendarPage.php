<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CalendarPage extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.pages.calendar-page';

    protected static ?string $title = 'Calendar';

    public static function getNavigationLabel(): string
    {
        return __('Calendar');
    }
}
