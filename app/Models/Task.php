<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query): Builder
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeForUser($query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeFilterByStatus($query, ?string $status): Builder
    {
        if (! $status) return $query;

        $allowedStatuses = ['pending', 'completed', 'cancelled'];

        if (in_array($status, $allowedStatuses, true)) {
            return $query->where('status', $status);
        }

        return $query;
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
        ]);
    }

    public function markAsCancelled(): void
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }
}
