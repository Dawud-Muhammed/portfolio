<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Support\ImageAsset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $publishedProjects = Project::query()
            ->published()
            ->orderByDesc('published_at')
            ->get();

        $projectsCollection = $publishedProjects->isNotEmpty()
            ? $publishedProjects
            : Project::query()->latest()->get();

        $projectCategoryNames = static function (Project $project): array {
            $source = is_array($project->filters) && ! empty($project->filters)
                ? $project->filters
                : (is_array($project->stack) ? $project->stack : []);

            return collect($source)
                ->map(static fn (mixed $value): string => trim((string) $value))
                ->filter()
                ->values()
                ->all();
        };

        $projectCategories = $projectsCollection
            ->flatMap(static fn (Project $project): array => $projectCategoryNames($project))
            ->map(static fn (string $name): array => [
                'name' => $name,
                'slug' => Str::slug($name),
            ])
            ->filter(static fn (array $category): bool => $category['slug'] !== '')
            ->unique('slug')
            ->sortBy('name')
            ->values()
            ->all();

        $projects = $projectsCollection
            ->map(static function (Project $project) use ($projectCategoryNames): array {
                $categoryNames = $projectCategoryNames($project);

                return [
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'description' => $project->description,
                    'image' => $project->image_url,
                    'stack' => $project->stack,
                    'categories' => collect($categoryNames)
                        ->map(static fn (string $name): string => Str::slug($name))
                        ->filter()
                        ->values()
                        ->all(),
                    'github' => $project->github_url,
                    'demo' => $project->demo_url,
                    'details' => $project->details,
                ];
            })
            ->values()
            ->all();

        $publishedSkills = Skill::query()
            ->published()
            ->orderByDesc('level')
            ->orderByDesc('years')
            ->get();

        $skills = $publishedSkills
            ->map(static fn (Skill $skill): array => [
                'id' => $skill->skill_id,
                'name' => $skill->name,
                'level' => $skill->level,
                'years' => $skill->years,
                'description' => $skill->description,
                'category' => $skill->category,
            ])
            ->values()
            ->all();

        $aboutSkills = $publishedSkills
            ->take(6)
            ->map(static fn (Skill $skill): string => $skill->name)
            ->values()
            ->all();

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(static fn (Testimonial $testimonial): array => [
                'quote' => $testimonial->quote,
                'author' => $testimonial->author,
                'role' => $testimonial->role,
                'avatar' => $testimonial->avatar_url,
            ])
            ->values()
            ->all();

        $navigationLinks = [
            [
                'key' => 'about',
                'label' => SiteSetting::get('nav_about_label', 'About'),
                'url' => SiteSetting::get('nav_about_url', route('home.about')),
            ],
            [
                'key' => 'skills',
                'label' => SiteSetting::get('nav_skills_label', 'Skills'),
                'url' => SiteSetting::get('nav_skills_url', route('home.skills')),
            ],
            [
                'key' => 'projects',
                'label' => SiteSetting::get('nav_projects_label', 'Projects'),
                'url' => SiteSetting::get('nav_projects_url', route('projects.index')),
            ],
            [
                'key' => 'testimonials',
                'label' => SiteSetting::get('nav_testimonials_label', 'Testimonials'),
                'url' => SiteSetting::get('nav_testimonials_url', route('home.testimonials')),
            ],
            [
                'key' => 'contact',
                'label' => SiteSetting::get('nav_contact_label', 'Contact'),
                'url' => SiteSetting::get('nav_contact_url', route('home.contact')),
            ],
        ];

        $siteSettings = [
            'page_title' => SiteSetting::get('page_title', 'Dawud Muhammed | Laravel Developer'),
            'meta_description' => SiteSetting::get('meta_description', 'Premium Laravel portfolio with dynamic sections, named route navigation, and persistent theme settings.'),
            'brand_name' => SiteSetting::get('brand_name', SiteSetting::get('hero_name', 'Dawud Muhammed')),
            'hero_name' => SiteSetting::get('hero_name', 'Dawud Muhammed'),
            'hero_title' => SiteSetting::get('hero_title', 'Laravel Developer'),
            'hero_cv_url' => SiteSetting::get('hero_cv_url', url('/')),
            'hero_cta_label' => SiteSetting::get('hero_cta_label', 'Download CV'),
            'hero_primary_cta_label' => SiteSetting::get('hero_primary_cta_label', 'View Projects'),
            'hero_availability_text' => SiteSetting::get('hero_availability_text', 'Available for freelance and full-time roles'),
            'hero_description' => SiteSetting::get('hero_description', 'I build robust, scalable backend systems powered by Laravel and polished interfaces using Tailwind CSS.'),
            'hero_background' => ImageAsset::resolve(
                SiteSetting::get('hero_background'),
                (string) config('seo.default_image', '')
            ),
            'hero_background_alt' => SiteSetting::get('hero_background_alt', 'Futuristic coding workstation with glowing monitors in a dark studio'),
            'about_badge' => SiteSetting::get('about_badge', 'About Me'),
            'about_heading' => SiteSetting::get('about_heading', 'Building dependable systems with clean engineering principles.'),
            'about_bio' => SiteSetting::get('about_bio', 'I design and ship Laravel products focused on reliability, maintainability, and user trust. From architecture to implementation, I prioritize clear communication, measurable outcomes, and long-term scalability.'),
            'about_profile_image' => ImageAsset::resolve(
                SiteSetting::get('about_profile_image'),
                '/storage/images/photo-1542831371-29b0f74f9713.jpg'
            ),
            'about_profile_alt' => SiteSetting::get('about_profile_alt', 'Profile portrait of Dawud Muhammed'),
            'skills_badge' => SiteSetting::get('skills_badge', 'Core Skills'),
            'skills_heading' => SiteSetting::get('skills_heading', 'Precision engineering with a product-first mindset.'),
            'skills_subheading' => SiteSetting::get('skills_subheading', 'Skill levels and counters animate on scroll, with category grouping powered by Laravel enums.'),
            'projects_badge' => SiteSetting::get('projects_badge', 'Featured Work'),
            'projects_heading' => SiteSetting::get('projects_heading', 'Crafted products with performance and polish.'),
            'testimonials_badge' => SiteSetting::get('testimonials_badge', 'Testimonials'),
            'testimonials_heading' => SiteSetting::get('testimonials_heading', 'Trusted by thoughtful teams and product leaders.'),
            'testimonials_subheading' => SiteSetting::get('testimonials_subheading', 'A few words from collaborators and stakeholders who value clear communication, sharp delivery, and polished execution.'),
            'contact_badge' => SiteSetting::get('contact_badge', 'Contact'),
            'contact_heading' => SiteSetting::get('contact_heading', 'Let us build something exceptional.'),
            'contact_subheading' => SiteSetting::get('contact_subheading', 'Send a message and I will respond as soon as possible.'),
            'contact_submit_label' => SiteSetting::get('contact_submit_label', 'Send Message'),
            'contact_submitting_label' => SiteSetting::get('contact_submitting_label', 'Sending...'),
            'contact_name_label' => SiteSetting::get('contact_name_label', 'Name'),
            'contact_email_label' => SiteSetting::get('contact_email_label', 'Email'),
            'contact_subject_label' => SiteSetting::get('contact_subject_label', 'Subject'),
            'contact_message_label' => SiteSetting::get('contact_message_label', 'Message'),
            'contact_validation_error' => SiteSetting::get('contact_validation_error', 'Please fix the highlighted fields.'),
            'contact_success_message' => SiteSetting::get('contact_success_message', 'Message sent successfully.'),
            'contact_error_message' => SiteSetting::get('contact_error_message', 'Unable to send your message right now.'),
            'contact_network_error' => SiteSetting::get('contact_network_error', 'A network error occurred. Please try again.'),
            'footer_copyright_name' => SiteSetting::get('footer_copyright_name', SiteSetting::get('hero_name', 'Dawud Muhammed')),
            'footer_blog_label' => SiteSetting::get('footer_blog_label', 'Blog'),
            'footer_github' => SiteSetting::get('footer_github', 'https://github.com/your-username'),
            'footer_linkedin' => SiteSetting::get('footer_linkedin', 'https://www.linkedin.com/in/your-username'),
            'footer_x' => SiteSetting::get('footer_x', 'https://x.com/your-username'),
            'footer_tiktok' => SiteSetting::get('footer_tiktok', 'https://www.tiktok.com/@your-username'),
            'footer_telegram' => SiteSetting::get('footer_telegram', 'https://t.me/your-username'),
            'footer_instagram' => SiteSetting::get('footer_instagram', 'https://www.instagram.com/your-username'),
            'footer_facebook' => SiteSetting::get('footer_facebook', 'https://www.facebook.com/your-username'),
            'footer_whatsapp' => SiteSetting::get('footer_whatsapp', 'https://wa.me/2340000000000'),
        ];

        return view('welcome', [
            'projects' => $projects,
            'projectCategories' => $projectCategories,
            'skills' => $skills,
            'aboutSkills' => $aboutSkills,
            'testimonials' => $testimonials,
            'navigationLinks' => $navigationLinks,
            'siteSettings' => $siteSettings,
        ]);
    }
}
