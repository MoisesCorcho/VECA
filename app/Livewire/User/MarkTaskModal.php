<?php

namespace App\Livewire\User;

use App\Models\Task;
use Filament\Notifications\Notification;
use Filament\Forms;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\TaskService;

class MarkTaskModal extends Component
{
    public Task $task;
    public ?string $action;

    #[On('mark-task-confirm')]
    public function openModal(Task $task, string $action): void
    {
        // The filament modal is opened using the `open-modal` event and the modal id
        $this->dispatch('open-modal', id: 'mark-task-modal');
        $this->task = $task;
        $this->action = $action;
    }

    public function confirm(TaskService $taskService): void
    {
        $result = match ($this->action) {
            'complete' => $taskService->completeTask($this->task->id, $this->task->user_id),
            'cancelled' => $taskService->cancelTask($this->task->id, $this->task->user_id),
            default => false,
        };

        if (! $result) {
            Notification::make()
                ->danger()
                ->title("Task cannot be marked as {$this->action}")
                ->send();
        } else {
            Notification::make()
                ->success()
                ->title("Task marked as {$this->action}")
                ->send();

            $this->dispatch('task-updated');
        }

        $this->dispatch('close-modal', id: 'mark-task-modal');
    }

    public function render()
    {
        return view('livewire.user.mark-task-modal');
    }
}
