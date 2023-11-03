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
        Schema::create('questionnaire_exams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('student_id')->constrained();
            $table->foreignUuid('module_id')->constrained()->on('questionnaire_modules');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaire_exams');
    }
};
