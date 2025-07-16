<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyAnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'date',
        'survey_id',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function surveyQuestionAnswers()
    {
        return $this->hasMany(SurveyQuestionAnswer::class, 'survey_answer_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
