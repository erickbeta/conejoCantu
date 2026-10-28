<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@conejocantu.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin88'), // Contraseña por defecto
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}