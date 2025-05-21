<?php

declare(strict_types=1);

namespace App\Helpers;

use Filament\Notifications\Notification;

final class FilamentHelpers
{
    /**
     * Prevent deletion if the record has related records
     *
     * @param mixed $record The model record
     * @param string $relation The relation name to check
     * @param \Closure $haltCallback A callback that can halt the execution
     * @return bool Whether the deletion was prevented
     */
    public static function preventDeletionIfHasRelated($record, string $relation, \Closure $haltCallback)
    {
        if ($record->hasAssociatedRecords($relation)) {
            Notification::make()
                ->title('Error')
                ->body("The record cannot be deleted because it has associated {$relation}.")
                ->danger()
                ->send();

            // Call the provided halt callback
            $haltCallback();
            return true;
        }
        return false;
    }
}
