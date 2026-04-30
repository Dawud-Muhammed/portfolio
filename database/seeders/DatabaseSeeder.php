<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only keep the essential Admin user
        $this->call(AdminUserSeeder::class);
        
        // Add any NEW seeders for your new databases below:
        // $this->call(YourNewSeeder::class);
    }
}