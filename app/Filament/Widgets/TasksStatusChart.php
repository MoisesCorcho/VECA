<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Widgets\ChartWidget;

class TasksStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Tasks Status';

    protected static ?int $sort = 5;

    protected static ?string $maxHeight = '300px';

    protected int | string | array $columnSpan = [
        'md' => 1,
        'lg' => 2,
    ];

    protected function getData(): array
    {
        $pendingTasks = Task::where('status', 'pending')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $cancelledTasks = Task::where('status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'data' => [$cancelledTasks, $pendingTasks, $completedTasks],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)', // Cancelled - Red
                        'rgb(255, 205, 86)', // Pending - Yellow
                        'rgb(75, 192, 192)', // Completed - Green
                    ],
                ],
            ],
            'labels' => [__('Cancelled'), __('Pending'), __('Completed')],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
