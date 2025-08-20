<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RecentActivityWidget;
use App\Filament\Widgets\SellerResponsesChart;
use App\Filament\Widgets\SurveyResponsesChart;
use App\Filament\Widgets\SurveyStatsOverview;
use App\Filament\Widgets\TasksStatusChart;
use App\Filament\Widgets\TopSurveysTable;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            SurveyStatsOverview::class,
            SurveyResponsesChart::class,
            SellerResponsesChart::class,
            TasksStatusChart::class,
            RecentActivityWidget::class,
        ];
    }

    public function getTitle(): string
    {
        return 'Dashboard - Statistics';
    }

    public function getHeading(): string
    {
        return 'General Statistics';
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
