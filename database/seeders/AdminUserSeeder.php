<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Dawud Muhammed',
            'email' => 'dawud2147@gmail.com',  
            'password' => Hash::make('muslim318#'),  
            'is_admin' => true,
        ]);
    }
}