<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SiteSettingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaults = [
            'hero_name' => 'Dawud Muhammed',
            'hero_title' => 'Laravel Developer',
            'hero_cv_url' => url('/'),
            'hero_background' => url(Storage::url('images/photo-1518770660439-4636190af475.jpg')),
            'about_bio' => 'I design and ship Laravel products focused on reliability, maintainability, and user trust. From architecture to implementation, I prioritize clear communication, measurable outcomes, and long-term scalability.',
            'about_profile_image' => url(Storage::url('images/photo-1542831371-29b0f74f9713.jpg')),
            'footer_github' => 'https://github.com/your-username',
            'footer_linkedin' => 'https://www.linkedin.com/in/your-username',
            'footer_x' => 'https://x.com/your-username',
            'footer_tiktok' => 'https://www.tiktok.com/@your-username',
            'footer_telegram' => 'https://t.me/your-username',
            'footer_instagram' => 'https://www.instagram.com/your-username',
            'footer_facebook' => 'https://www.facebook.com/your-username',
            'footer_whatsapp' => 'https://wa.me/2340000000000',
        ];

        $payload = [];
        foreach ($defaults as $key => $value) {
            $payload[] = [
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SiteSetting::query()->upsert($payload, ['key'], ['value', 'updated_at']);
    }
}
