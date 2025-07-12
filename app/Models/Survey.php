<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Scope;

class Survey extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'user_id'];

    public function questions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SurveyAnswer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sellers(): HasMany
    {
        return $this->hasMany(User::class, 'survey_id');
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    #[Scope]
    public function active()
    {
        return $this->where('status', true);
    }
}
