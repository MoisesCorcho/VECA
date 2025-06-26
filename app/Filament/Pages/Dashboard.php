<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        return 'Dashboard - Análisis Power BI';
    }

    public function getHeading(): string
    {
        return 'Panel de Control y Análisis';
    }
}
