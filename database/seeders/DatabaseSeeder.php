<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Crear usuario administrador solo si no existe
        if (!User::where('email', 'admin@system.com')->exists()) {
            User::create([
                'uuid' => Str::uuid(),
                'first_name' => 'Admin',
                'last_name' => 'System',
                'username' => 'snpoc_admin',
                'email' => 'admin@system.com',
                'password' => Hash::make('123456789'),
                'role' => 'admin'
            ]);
        }
    }
}