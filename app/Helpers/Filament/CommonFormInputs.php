<?php

namespace App\Helpers\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Enums\DniType;

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
}
