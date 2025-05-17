@props(['question'])

<div class="space-y-3">
    @foreach ($question->data as $value => $label)
        <div class="flex items-center gap-x-2">
            <x-filament::input.checkbox 
                wire:model.live="answers.{{ $question->id }}.{{ $label }}"
                id="checkbox-{{ $question->id }}-{{ $loop->index }}" />
            <label 
                for="checkbox-{{ $question->id }}-{{ $loop->index }}" 
                class="text-sm">
                {{ $label }}
            </label>
        </div>
    @endforeach
</div>
