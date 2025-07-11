@props(['question', 'answers'])

@php
    $sqService = app(\App\Services\SurveyQuestionService::class);
@endphp

<x-filament::input.wrapper class="w-full">
    <x-filament::input.select wire:model.live="answers.{{ $question->id }}" class="w-full">
        <option value="">{{ __('Select an option') }}</option>

        @if ($question->options_source == 'database')
            @foreach ($sqService->getDatabaseOptions($question->options_model, $question, $answers) as $option)
                <option value="{{ $option->{$question->options_label_column} }}">
                    {{ $option->{$question->options_label_column} }}
                </option>
            @endforeach
        @else
            @foreach ($question->data ?? [] as $optionValue => $optionLabel)
                <option value="{{ $optionLabel }}">
                    {{ $optionLabel }}
                </option>
            @endforeach
        @endif

    </x-filament::input.select>
</x-filament::input.wrapper>
