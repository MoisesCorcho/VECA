@props(['question'])

<div class="space-y-3">
    @foreach ($question->data as $value => $label)
        <div class="flex items-center gap-x-2">
            <x-filament::input.checkbox wire:model.live="answers.{{ $question->id }}.{{ $label }}" />
            <label class="text-sm">
                {{ $label }}
            </label>
        </div>
    @endforeach
</div>
