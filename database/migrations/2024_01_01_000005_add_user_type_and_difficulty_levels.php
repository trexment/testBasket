<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Agregar tipos de usuario
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['arbitro', 'oficial', 'entrenador'])->default('arbitro')->after('role');
        });

        // Mejorar tabla de preguntas con más campos
        Schema::table('questions', function (Blueprint $table) {
            $table->string('question_code')->nullable()->after('id'); // Ej: Q001, Q002
            $table->json('applicable_roles')->nullable()->after('category'); // ['arbitro', 'oficial', 'entrenador']
            $table->integer('order')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['question_code', 'applicable_roles', 'order']);
        });
    }
};
