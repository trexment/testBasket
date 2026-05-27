<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Set default user_type for existing users
        DB::table('users')
            ->whereNull('user_type')
            ->update(['user_type' => 'arbitro']);

        // Make user_type NOT NULL with default
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['arbitro', 'oficial', 'entrenador'])
                ->default('arbitro')
                ->change();
        });
    }

    public function down(): void
    {
        // Revert to nullable
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['arbitro', 'oficial', 'entrenador'])
                ->nullable()
                ->change();
        });
    }
};
