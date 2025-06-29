<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->enum('options_source', ['static', 'database'])->default('static');
            $table->string('options_model')->nullable()->comment('Eloquent Model');
            $table->string('options_label_column')->nullable()->comment('Column shown');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->dropColumn('options_source');
            $table->dropColumn('options_model');
            $table->dropColumn('options_label_column');
        });
    }
};
