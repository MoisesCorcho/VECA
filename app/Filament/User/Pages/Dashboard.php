<?php

namespace App\Filament\User\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Services\TaskService;
use App\Models\Task;
use Livewire\Attributes\On;

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

    public function filterByStatus(?string $status): void
    {
        $this->statusFilter = $status;
        $this->loadTasks();
    }

    public function confirmMarkTask(Task $task, string $action)
    {
        $this->dispatch('mark-task-confirm', task: $task, action: $action);
    }

    #[On('task-updated')]
    public function reload()
    {
        $this->loadTasks();
    }
}
