<?php

use App\Enums\DniType;
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
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('dni_type')->default(DniType::CC->value);
            $table->string('dni');
            $table->string('cellphone_1')->unique();
            $table->string('cellphone_2')->unique();
            $table->string('phone');
            $table->date('birthdate');
            $table->string('email')->unique();
            $table->foreignUuid('organization_id')->constrained();
            $table->foreignId('member_position_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
