<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User (if doesn't exist)
        User::firstOrCreate(
            ['email' => 'admin@bookease.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Regular Users
        $users = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Bob Johnson', 'email' => 'bob@example.com'],
            ['name' => 'Alice Williams', 'email' => 'alice@example.com'],
            ['name' => 'Charlie Brown', 'email' => 'charlie@example.com'],
            ['name' => 'Diana Prince', 'email' => 'diana@example.com'],
            ['name' => 'Edward Norton', 'email' => 'edward@example.com'],
            ['name' => 'Fiona Green', 'email' => 'fiona@example.com'],
            ['name' => 'George Wilson', 'email' => 'george@example.com'],
            ['name' => 'Helen Davis', 'email' => 'helen@example.com'],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ]
            );
        }
    }
}
