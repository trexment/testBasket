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
            'is_active' => true,
        ]);

        // Test user
        User::create([
            'name' => 'Usuario Prueba',
            'email' => 'user@test.frannunez.es',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}
