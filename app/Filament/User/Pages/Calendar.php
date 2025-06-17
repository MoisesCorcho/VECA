<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class Calendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $view = 'filament.user.pages.calendar';
}
