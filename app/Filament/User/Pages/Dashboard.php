<?php

namespace App\Filament\User\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Services\TaskService;
use App\Models\Task;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.user.pages.dashboard';

    public $tasks;
    public $taskStats;

    public $statusFilter = 'pending';

    public function getWidgets(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        return '';
    }

    public function getHeading(): string
    {
        return '';
    }

    public function mount(): void
    {
        $this->loadTasks();
    }

    public function getTaskServiceProperty()
    {
        return app(TaskService::class);
    }

    private function loadTasks(): void
    {
        $this->tasks = $this->taskService->getTasksForUser(auth()->id(), $this->statusFilter);
        $this->taskStats = $this->taskService->getTaskStats(auth()->id());
    }

    public function markTask(Task $task, string $action): void
    {
        $result = match ($action) {
            'complete' => $this->taskService->completeTask($task->id, $task->user_id),
            'cancelled' => $this->taskService->cancelTask($task->id, $task->user_id),
            default => false
        };

        if (! $result) {
            Notification::make()
                ->danger()
                ->title("Task cannot be marked as $action")
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title("Task marked as $action")
            ->send();

        $this->loadTasks();
    }

    public function filterByStatus(?string $status): void
    {
        $this->statusFilter = $status;
        $this->loadTasks();
    }
}
