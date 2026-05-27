<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->decimal('score_percentage', 5, 2);
            $table->enum('category_type', ['arbitro', 'oficial_mesa', 'mixto'])->default('mixto');
            $table->string('difficulty_filter')->nullable(); // "baja,media,alta" or null
            $table->integer('time_limit_seconds')->default(45);
            $table->integer('duration_seconds')->nullable();
            $table->enum('status', ['completed', 'abandoned'])->default('completed');
            $table->timestamps();
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};
