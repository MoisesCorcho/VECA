<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SurveyResponsesChart extends ChartWidget
{
    protected static ?string $heading = 'Answers per Survey';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $surveyData = Survey::withCount('answers')
            ->orderBy('answers_count', 'desc')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => __('Number of answers'),
                    'data' => $surveyData->pluck('answers_count')->toArray(),
                    'backgroundColor' => [
                        'rgb(54, 162, 235)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)',
                        'rgb(199, 199, 199)',
                        'rgb(83, 102, 255)',
                        'rgb(255, 99, 255)',
                        'rgb(99, 255, 132)',
                    ],
                ],
            ],
            'labels' => $surveyData->pluck('title')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
