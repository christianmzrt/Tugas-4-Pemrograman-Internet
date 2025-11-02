<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kampus.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // Buat user biasa untuk testing
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@kampus.com',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);
    }
}