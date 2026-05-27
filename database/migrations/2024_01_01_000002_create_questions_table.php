<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->char('correct_answer', 1); // A, B, C, D
            $table->text('explanation');
            $table->enum('category', ['arbitro', 'oficial_mesa']); // árbitro o oficial de mesa
            $table->enum('difficulty', ['baja', 'media', 'alta'])->default('media');
            $table->string('reference')->nullable(); // Ej: "Art. 29 - Regla de 8 segundos"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('category');
            $table->index('difficulty');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
