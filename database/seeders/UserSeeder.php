<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Administrador',
            'email' => env('ADMIN_EMAIL', 'admin@test.frannunez.es'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'SecureAdminPassword123!')),
            'role' => 'admin',
            'user_type' => 'arbitro', // Default to arbitro
            'is_active' => true,
        ]);

        // Test user - Árbitro
        User::create([
            'name' => 'Usuario Prueba - Árbitro',
            'email' => 'user@test.frannunez.es',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'user_type' => 'arbitro',
            'is_active' => true,
        ]);

        // Test user - Oficial de Mesa
        User::create([
            'name' => 'Usuario Prueba - Oficial',
            'email' => 'oficial@test.frannunez.es',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'user_type' => 'oficial',
            'is_active' => true,
        ]);

        // Test user - Entrenador
        User::create([
            'name' => 'Usuario Prueba - Entrenador',
            'email' => 'entrenador@test.frannunez.es',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'user_type' => 'entrenador',
            'is_active' => true,
        ]);
    }
}
