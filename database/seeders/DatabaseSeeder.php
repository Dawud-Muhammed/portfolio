<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->call(SiteSettingSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(AdminUserSeeder::class);
    }
}