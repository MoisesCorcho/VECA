<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                {{ __('Pending Tasks') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                {{ __('Your tasks that need to be completed') }}
            </p>
            <div class="mt-4 flex space-x-6 text-sm">
                <span class="text-gray-600 dark:text-gray-400">
                    {{ __('Completed') }}: <span
                        class="font-semibold text-green-600">{{ $taskStats['completed'] }}</span>
                </span>
                <span class="text-gray-600 dark:text-gray-400">
                    {{ __('Cancelled') }}: <span class="font-semibold text-red-600">{{ $taskStats['cancelled'] }}</span>
                </span>
                <span class="text-gray-600 dark:text-gray-400">
                    {{ __('Total') }}: <span class="font-semibold">{{ $taskStats['total'] }}</span>
                </span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Tasks') }}</h3>
            <div class="flex items-center bg-white dark:bg-gray-900/50 p-1 rounded-lg shadow-sm space-x-1">
                <button type="button" wire:click="filterByStatus(null)"
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ !$statusFilter ? 'bg-blue-600 text-white shadow' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    {{ __('All') }}
                </button>
                <button type="button" wire:click="filterByStatus('pending')"
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $statusFilter == 'pending' ? 'bg-amber-500 text-white shadow' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    {{ __('Pending') }}
                </button>
                <button type="button" wire:click="filterByStatus('completed')"
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $statusFilter == 'completed' ? 'bg-green-600 text-white shadow' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    {{ __('Completed') }}
                </button>
                <button type="button" wire:click="filterByStatus('cancelled')"
                    class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $statusFilter == 'cancelled' ? 'bg-red-600 text-white shadow' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    {{ __('Cancelled') }}
                </button>
            </div>
        </div>


        @if (count($tasks) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($tasks as $task)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200 flex flex-col">
                        <div class="p-6 flex-grow">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center min-w-0">
                                    <div @class([
                                        'w-3 h-3 rounded-full mr-3 flex-shrink-0',
                                        'bg-amber-500' => $task->status === 'pending',
                                        'bg-green-500' => $task->status === 'completed',
                                        'bg-red-500' => $task->status === 'cancelled',
                                    ])></div>
                                    <h3
                                        class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                        {{ $task->title }}
                                    </h3>
                                </div>
                                <span @class([
                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                    'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200' =>
                                        $task->status === 'pending',
                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' =>
                                        $task->status === 'completed',
                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' =>
                                        $task->status === 'cancelled',
                                ])>
                                    {{ __(ucfirst($task->status)) }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Created') }}: {{ $task->created_at->format('d/m/Y H:i') }}
                            </div>
                            @if ($task->status !== 'pending')
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Marked') }}: {{ $task->updated_at->format('d/m/Y H:i') }}
                                </div>
                            @endif

                            @if ($task->status === 'pending')
                                <div class="flex items-center space-x-2">
                                    <button type="button"
                                        wire:click="confirmMarkTask({{ $task->id }}, 'cancelled')"
                                        class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        {{ __('Cancel') }}
                                    </button>
                                    <button type="button"
                                        wire:click="confirmMarkTask({{ $task->id }}, 'complete')"
                                        class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ __('Complete') }}
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-20 text-center">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
                    {{ __('You have no tasks in this section') }}
                </h3>
            </div>
        @endif
    </div>

    @livewire('user.mark-task-modal')
</x-filament-panels::page>
