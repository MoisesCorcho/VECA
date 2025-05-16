<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyQuestionAnswerFactory> */
    use HasFactory;

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
}
