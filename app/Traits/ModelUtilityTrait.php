<?php

declare(strict_types=1);

namespace App\Traits;

use InvalidArgumentException;
use BadMethodCallException;

trait ModelUtilityTrait
{
    /**
     * Verify is there is at least one record in the specified relation.
     *
     * @param string $relation Relation name to check
     * @return bool True if there is at least one record, false otherwise
     * @throws BadMethodCallException if the relation does not exist
     * @throws InvalidArgumentException if the relation name is empty
     */
    public function hasAssociatedRecords(string $relation): bool
    {
        // Validate relation name is not empty
        if (empty($relation)) {
            throw new InvalidArgumentException('The relation name cannot be empty.');
        }

        // Verify if the relation exists
        if (!$this->{$relation}()) {
            throw new BadMethodCallException(
                sprintf('The relationship "%s" does not exist on %s', $relation, static::class)
            );
        }

        return $this->{$relation}()->exists();
    }
}
