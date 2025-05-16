<div class="space-y-2">
    @foreach ($options as $value => $label)
        <label class="flex items-center gap-x-2 text-base text-body-color dark:text-gray-100">
            <input
                type="radio"
                value="{{ $label }}"
                name="answers[{{ $questionId }}]"
                wire:model.defer="answers.{{ $questionId }}"
                class="text-primary focus:ring-primary border-gray-300 dark:border-gray-700 dark:bg-gray-800"
            />
            <span class="text-sm">{{ $label }}</span>
        </label>
    @endforeach
</div>
