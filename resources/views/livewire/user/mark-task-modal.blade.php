<x-filament::modal width="md" id="mark-task-modal">
    <x-slot name="header">
        Confirm {{ ucfirst($action) }} Task
    </x-slot>

    <p class="text-sm text-gray-400">
        Are you sure you want to mark the task
        <strong>{{ $task?->title ?? 'Title not found' }}</strong>
        as <strong>{{ $action ?? 'Action not found' }}</strong>?
    </p>


    <x-slot name="footer">
        <x-filament::button x-on:click="$dispatch('close-modal', { id: 'mark-task-modal' })" color="gray">
            Cancel
        </x-filament::button>

        <x-filament::button wire:click="confirm" color="{{ $action === 'cancelled' ? 'danger' : 'success' }}">
            Yes
        </x-filament::button>
    </x-slot>
</x-filament::modal>
