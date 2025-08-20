<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\User;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class SurveyStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total surveys
        $totalSurveys = Survey::count();

        // Total answers
        $totalAnswers = SurveyAnswer::count();

        // active surveys
        $activeSurveys = Survey::where('status', true)->count();

        // Seller answers (Users with seller role)
        $sellerAnswers = SurveyAnswer::whereHas('user', function ($query) {
            $query->whereHas('roles', function ($roleQuery) {
                $roleQuery->where('name', 'Seller');
            });
        })->count();

        // Pending tasks
        $pendingTasks = Task::where('status', 'pending')->count();

        // Average answers per survey
        $avgAnswersPerSurvey = $totalSurveys > 0 ? round($totalAnswers / $totalSurveys, 1) : 0;

        return [
            Stat::make('Total Surveys', $totalSurveys)
                ->label(__('Total Surveys'))
                ->description('Surveys created')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make('Active Surveys', $activeSurveys)
                ->label(__('Active Surveys'))
                ->description('Surveys enabled')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Responses', $totalAnswers)
                ->label(__('Total Responses'))
                ->description('Responses received')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('info'),

            Stat::make('Seller Responses', $sellerAnswers)
                ->label(__('Seller Responses'))
                ->description('Responses from Seller users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),

            Stat::make('Pending Tasks', $pendingTasks)
                ->label(__('Pending Tasks'))
                ->description('Tasks to complete')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($pendingTasks > 0 ? 'danger' : 'success'),

            Stat::make('Avg Responses/Survey', $avgAnswersPerSurvey)
                ->label(__('Avg Responses/Survey'))
                ->description('Responses per survey')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('primary'),
        ];
    }
}
