<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
