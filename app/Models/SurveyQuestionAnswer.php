<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyQuestionAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyQuestionAnswerFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'answer',
        'survey_question_id',
        'survey_answer_id'
    ];

    protected function casts(): array
    {
        return [
            'answer' => 'array',
        ];
    }

    public function surveyQuestion(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class, 'survey_question_id');
    }

    public function surveyAnswer(): BelongsTo
    {
        return $this->belongsTo(SurveyAnswer::class, 'survey_answer_id');
    }
}
