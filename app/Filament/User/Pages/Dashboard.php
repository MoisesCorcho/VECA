<?php

namespace App\Filament\User\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Services\TaskService;
use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Dashboard extends BaseDashboard
{
    use WithPagination;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.user.pages.dashboard';

    public $taskStats;

    public $statusFilter = 'pending';

    #[Computed]
    public function tasks()
    {
        return $this->taskService->getTasksForUser(auth()->id(), $this->statusFilter);
    }

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
        $this->taskStats = $this->taskService->getTaskStats(auth()->id());
    }

    public function filterByStatus(?string $status): void
    {
        $this->statusFilter = $status;
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
