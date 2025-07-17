<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasHierarchyTrait;

class SurveyQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyQuestionFactory> */
    use HasFactory, HasHierarchyTrait;

    protected $fillable = [
        'type',
        'question',
        'description',
        'data',
        'survey_id',
        'parent_id',
        'triggering_answer',
        'is_task_trigger'
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'triggering_answer' => 'array',
            'is_task_trigger' => 'boolean',
        ];
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }
}
