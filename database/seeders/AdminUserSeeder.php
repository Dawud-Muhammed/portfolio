<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'dawud2147@gmail.com'],  // Check by email
            [
                'name' => 'Dawud Muhammed',
                'password' => Hash::make('muslim318#'),  // Keep or update password
                'is_admin' => true,
            ]
        );
    }
}