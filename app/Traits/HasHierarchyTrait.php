<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasHierarchyTrait
{
    public function getMaxDepth(): int
    {
        return 1;
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getDepth(): int
    {
        return $this->parent ? $this->parent->getDepth() + 1 : 0;
    }

    public function canHaveChildren(): bool
    {
        return $this->getDepth() < $this->getMaxDepth();
    }

    public function hasCircularReference($newParentId): bool
    {
        if (! $newParentId) {
            return false;
        }

        if ($this->id === $newParentId) {
            return true;
        }

        return false;
    }
}
