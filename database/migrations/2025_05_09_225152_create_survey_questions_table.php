<?php

use App\Models\Survey;
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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('Question type - text, textarea, select, radio, checkbox');
            $table->string('question')->comment('Question title');
            $table->text('description')->nullable()->comment('Question description');
            $table->text('data')->nullable()->comment('Question data/options');
            $table->foreignIdFor(Survey::class, 'survey_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
