@props(['question'])

<div class="space-y-2">
    @foreach ($question->data as $value => $label)
        <label class="flex items-center gap-x-2 text-base text-body-color dark:text-gray-100">
            <input
                type="radio"
                value="{{ $label }}"
                name="answers[{{ $question->id }}]"
                wire:model.live="answers.{{ $question->id }}"
                class="text-primary focus:ring-primary border-gray-300 dark:border-gray-700 dark:bg-gray-800"
            />
            <span class="text-sm">{{ $label }}</span>
        </label>
    @endforeach
</div>
