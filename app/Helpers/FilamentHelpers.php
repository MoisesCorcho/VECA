<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

final class FilamentHelpers
{
    /**
     * Prevent deletion if the record has related records
     *
     * @param Model $record The model record
     * @param string $relation The relation name to check
     * @param \Closure $haltCallback A callback that can halt the execution
     * @return bool Whether the deletion was prevented
     */
    public static function preventDeletionIfHasRelated(Model $record, string $relation, \Closure $haltCallback): bool
    {
        if ($record->hasAssociatedRecords($relation)) {
            Notification::make()
                ->title('Error')
                ->body("The record cannot be deleted because it has associated {$relation}.")
                ->danger()
                ->send();

            $haltCallback();
            return true;
        }
        return false;
    }

    /**
     * Verifies if a field from the visit form will be disabled based on the given conditions
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $record
     * @param  mixed  $currentStatus Current status
     * @param  array  $disabledOnOriginalStatuses Original statues that disable the field
     * @param  array  $disabledOnCurrentStatuses Actual statues that disable the field
     * @param  array  $additionalConditions Additional conditions
     * @param  bool  $disableOnCreate If the field should be disabled on create (default false)
     * @param  bool  $disableOnEdit If the field should be disabled on edit (default false)
     * @return bool
     */
    public static function disableFieldFromVisitForm(
        ?Model $record,
        mixed $currentStatus = null,
        array $disabledOnOriginalStatuses = [],
        array $disabledOnCurrentStatuses = [],
        array $additionalConditions = [],
        bool $disableOnCreate = false,
        bool $disableOnEdit = false,
    ): bool {
        // If is creation
        if (!$record) {

            if ($disableOnCreate) {
                return true;
            }

            if ($currentStatus && in_array($currentStatus, $disabledOnCurrentStatuses)) {
                return true;
            }

            return false;
        }

        if ($disableOnEdit) {
            return true;
        }

        $originalStatus = $record->getOriginal('status') ?? $record->status;

        if (in_array($originalStatus, $disabledOnOriginalStatuses)) {
            return true;
        }

        if ($currentStatus && in_array($currentStatus, $disabledOnCurrentStatuses)) {
            return true;
        }

        foreach ($additionalConditions as $condition) {
            if (is_callable($condition)) {
                if ($condition($record, $currentStatus, $originalStatus)) {
                    return true;
                }
            } elseif (is_bool($condition) && $condition) {
                return true;
            }
        }

        return false;
    }
}
