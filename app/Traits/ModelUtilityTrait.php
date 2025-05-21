<?php

declare(strict_types=1);

namespace App\Traits;

trait ModelUtilityTrait
{
    public function hasAssociatedRecords(string $relation)
    {
        return $this->{$relation}->isNotEmpty();
    }
}
