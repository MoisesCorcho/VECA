<?php

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_question_answers', function (Blueprint $table) {
            $table->id();
            $table->text('answer')->nullable();
            $table->foreignIdFor(SurveyQuestion::class, 'survey_question_id')->constrained();
            $table->foreignIdFor(SurveyAnswer::class, 'survey_answer_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_question_answers');
    }
};
