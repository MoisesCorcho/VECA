<div class="space-y-2">
    @foreach ($options as $value => $label)
        <label class="flex items-center space-x-2 text-base text-body-color dark:text-gray-100">
            <input
                type="checkbox"
                value="{{ $label }}"
                wire:model.defer="answers.{{ $questionId }}.{{ $label }}"
                class="text-primary focus:ring-primary border-gray-300 dark:border-gray-700 dark:bg-gray-800"
            />
            <span>{{ $label }}</span>
        </label>
    @endforeach
</div>
