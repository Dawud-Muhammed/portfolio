<?php

return [
    'default_name' => env('SEO_DEFAULT_NAME', 'Dawud Muhammed'),
    'job_title' => env('SEO_JOB_TITLE', 'Laravel Developer'),
    'default_description' => env(
        'SEO_DEFAULT_DESCRIPTION',
        'Premium Laravel portfolio featuring projects, case studies, and engineering insights.'
    ),
    'default_image' => env(
        'SEO_DEFAULT_IMAGE',
        'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1600&q=80'
    ),
    'default_url' => env('SEO_DEFAULT_URL', env('APP_URL', 'http://localhost')),
    'social' => [
        'github' => env('SEO_GITHUB_URL', 'https://github.com/your-username'),
        'linkedin' => env('SEO_LINKEDIN_URL', 'https://www.linkedin.com/in/your-username'),
        'x' => env('SEO_X_URL', 'https://x.com/your-username'),
    ],
];
