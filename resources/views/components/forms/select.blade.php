@props(['question'])

<x-filament::input.wrapper class="w-full">
    <x-filament::input.select 
        wire:model.live="answers.{{ $question->id }}" 
        class="w-full">
        <option value="">{{ __('Select an option') }}</option>
        @foreach ($question->data ?? [] as $optionValue => $optionLabel)
            <option value="{{ $optionLabel }}">
                {{ $optionLabel }}
            </option>
        @endforeach
    </x-filament::input.select>
</x-filament::input.wrapper>
