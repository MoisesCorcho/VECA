<?php

namespace App\Helpers\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Enums\DniType;
use Filament\Forms\Components\Textarea;

/**
 * This class provides common form inputs definitions used in Filament forms.
 * facilitating reuse and consistency across different parts of the application.
 */
class CommonFormInputs
{
    /**
     * Create a TextInput component for an identification number.
     *
     * @param string $fieldName The name of the field.
     * @param string $label The label for the input field.
     * @param string $placeholder The placeholder text for the input field.
     * @param int $maxLength The maximum length of the input value.
     *
     * @return TextInput The configured TextInput component.
     */
    public static function identificationNumber(
        string $fieldName = 'identification_number',
        string $label = 'Identification Number',
        string $placeholder = 'Enter identification number',
        int $maxLength = 20
    ): TextInput {
        return TextInput::make($fieldName)
            ->label(__($label))
            ->placeholder(__($placeholder))
            ->required()
            ->unique(ignoreRecord: true)
            ->numeric()
            ->maxLength($maxLength);
    }

    /**
     * Create a TextInput component for an email address.
     *
     * @param string $fieldName The name of the field.
     * @param string $label The label for the input field.
     * @param string $placeholder The placeholder text for the input field.
     * @param int $maxLength The maximum length of the input value.
     *
     * @return TextInput The configured TextInput component.
     */
    public static function email(
        string $fieldName = 'email',
        string $label = 'Email',
        string $placeholder = 'example@domain.com',
        int $maxLength = 255
    ): TextInput {
        return TextInput::make($fieldName)
            ->label(__($label))
            ->email()
            ->required()
            ->unique(ignoreRecord: true)
            ->placeholder(__($placeholder))
            ->maxLength($maxLength);
    }

    /**
     * Create a TextInput component for a phone number.
     *
     * @param string $fieldName The name of the field.
     * @param string $label The label for the input field.
     * @param string $placeholder The placeholder text for the input field.
     *
     * @return TextInput The configured TextInput component.
     */
    public static function phoneNumber(
        string $fieldName = 'phone_number',
        string $label = 'Phone Number',
        string $placeholder = 'Enter phone number',
    ): TextInput {
        return TextInput::make($fieldName)
            ->label(__($label))
            ->tel()
            ->prefix('+')
            ->required()
            ->maxLength(20)
            ->placeholder(__($placeholder))
            ->regex('/^[+\d\s()-]+$/');
    }

    /**
     * Create a Select component for an ID type.
     *
     * @param string $fieldName The name of the field.
     * @param string $label The label for the input field.
     *
     * @return Select The configured Select component.
     */
    public static function idTypeSelect(
        string $fieldName = 'id_type',
        string $label = 'ID Type',
    ): Select {
        return Select::make($fieldName)
            ->label(__($label))
            ->options(DniType::keyValuesCombined())
            ->default(DniType::CC->value)
            ->searchable()
            ->required();
    }


    /**
     * Create a TextInput component for a field that should only be displayed
     * and not edited.
     *
     * @param string $fieldName The name of the field.
     * @param string $label The label for the input field.
     * @param \Closure|null $formatter A closure that takes the value of the field and returns its formatted value.
     *
     * @return \Filament\Forms\Components\TextInput The configured TextInput component.
     */
    public static function displayOnlyTextInput(string $fieldName, string $label, ?callable $formatter = null): TextInput
    {
        return TextInput::make($fieldName)
            ->label(__($label))
            ->disabled()
            ->dehydrated(false)
            ->formatStateUsing($formatter);
    }

    /**
     * Create a Textarea component for a field that should only be displayed
     * and not edited.
     *
     * @param string $fieldName The name of the field.
     * @param string $label The label for the textarea.
     * @param int $rows The number of rows for the textarea.
     * @param \Closure|null $formatter A closure that takes the value of the field and returns its formatted value.
     *
     * @return \Filament\Forms\Components\Textarea The configured Textarea component.
     */
    public static function displayOnlyTextarea(string $fieldName, string $label, int $rows = 2, ?callable $formatter = null): Textarea
    {
        return Textarea::make($fieldName)
            ->label(__($label))
            ->disabled()
            ->dehydrated(false)
            ->rows($rows)
            ->formatStateUsing($formatter);
    }


    public static function getEntityFormatter(string $entity, string $entityField, string $attribute = 'name'): \Closure
    {
        return function (callable $get) use ($entity, $entityField, $attribute) {
            $entityId = $get($entityField);
            if ($entityId) {
                return $entity::find($entityId)?->{$attribute};
            }
            return null;
        };
    }
}
