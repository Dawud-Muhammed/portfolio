<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'quote' => 'The work felt considered from the first wireframe to the final deployment. The result was fast, refined, and easy for the team to maintain.',
                'author' => 'Amina Rahman',
                'role' => 'Product Manager, Northstar Studio',
                'avatar' => Storage::url('images/photo-1494790108377-be9c29b29330.jpg'),
            ],
            [
                'quote' => 'Technical decisions were explained clearly and delivered with discipline. The entire process felt calm, structured, and high-trust.',
                'author' => 'Daniel Okafor',
                'role' => 'Founder, FrameShift Labs',
                'avatar' => Storage::url('images/photo-1500648767791-00dcc994a43e.jpg'),
            ],
            [
                'quote' => 'The interface looked premium without sacrificing usability. It was exactly the balance we wanted for a client-facing portfolio experience.',
                'author' => 'Sofia Mensah',
                'role' => 'Design Lead, Copper & Co.',
                'avatar' => Storage::url('images/photo-1438761681033-6461ffad8d80.jpg'),
            ],
            [
                'quote' => 'Performance, structure, and polish all landed at a level that made the project feel production-ready from day one.',
                'author' => 'Michael Chen',
                'role' => 'Engineering Manager, Atlas Digital',
                'avatar' => Storage::url('images/photo-1506794778202-cad84cf45f1d.jpg'),
            ],
            [
                'quote' => 'The collaboration was concise and effective. Every iteration moved the product closer to what the business actually needed.',
                'author' => 'Grace Ibe',
                'role' => 'Operations Director, Solis Works',
                'avatar' => null,
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::query()->updateOrCreate(
                ['author' => $testimonial['author']],
                [
                    'quote' => $testimonial['quote'],
                    'role' => $testimonial['role'],
                    'avatar' => $testimonial['avatar'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}