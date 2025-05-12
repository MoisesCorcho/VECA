<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyQuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'question',
        'description',
        'data',
        'survey_id',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}
