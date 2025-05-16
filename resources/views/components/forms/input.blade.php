@props(['question', 'type'])

<x-filament::input.wrapper class="w-full">
    <x-filament::input
        type="{{ $type ?? 'text' }}"
        wire:model.live="answers.{{ $question->id }}"
        class="w-full"
        placeholder="Put your answer here..." />
</x-filament::input.wrapper>
