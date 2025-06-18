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
     * Function to determine if a field should be disabled
     *
     * @param array $disabledOnOriginalStatuses Original statues that disable the field
     * @param array $disabledOnCurrentStatuses Actual statues that disable the field
     * @param array $additionalConditions Additional conditions
     * @param bool $disableOnCreate If the field should be disabled on create (default false)
     * @param bool $disableOnEdit If the field should be disabled on edit (default false)
     */
    public static function shouldDisable(
        array $disabledOnOriginalStatuses = [],
        array $disabledOnCurrentStatuses = [],
        array $additionalConditions = [],
        bool $disableOnCreate = false,
        bool $disableOnEdit = false,
    ): callable {
        return function (callable $get, ?Model $record) use (
            $disabledOnOriginalStatuses,
            $disabledOnCurrentStatuses,
            $additionalConditions,
            $disableOnCreate,
            $disableOnEdit
        ) {
            // If is creation
            if (!$record) {
                if ($disableOnCreate) {
                    return true;
                }

                // verify conditions based on current status
                $currentStatus = $get('status');
                if ($currentStatus && in_array($currentStatus, $disabledOnCurrentStatuses)) {
                    return true;
                }

                return false;
            }

            // If is edit
            if ($disableOnEdit) {
                return true;
            }

            // If is update
            $currentStatus = $get('status');
            $originalStatus = $record->getOriginal('status') ?? $record->status;

            // Verify conditions based on original status
            if (in_array($originalStatus, $disabledOnOriginalStatuses)) {
                return true;
            }

            // Verify conditions based on current status
            if ($currentStatus && in_array($currentStatus, $disabledOnCurrentStatuses)) {
                return true;
            }

            // Verify additional conditions
            foreach ($additionalConditions as $condition) {
                if (is_callable($condition)) {
                    if ($condition($get, $record, $currentStatus, $originalStatus)) {
                        return true;
                    }
                } elseif (is_bool($condition) && $condition) {
                    return true;
                }
            }

            return false;
        };
    }
}
