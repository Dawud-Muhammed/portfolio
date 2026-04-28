<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * @var array<int, string>
     */
    private const KEYS = [
        'page_title',
        'meta_description',
        'brand_name',
        'hero_name',
        'hero_title',
        'hero_cv_url',
        'hero_cta_label',
        'hero_primary_cta_label',
        'hero_availability_text',
        'hero_description',
        'hero_background',
        'hero_background_alt',
        'about_badge',
        'about_heading',
        'about_bio',
        'about_profile_image',
        'about_profile_alt',
        'skills_badge',
        'skills_heading',
        'skills_subheading',
        'nav_about_label',
        'nav_skills_label',
        'nav_projects_label',
        'nav_testimonials_label',
        'nav_contact_label',
        'nav_about_url',
        'nav_skills_url',
        'nav_projects_url',
        'nav_testimonials_url',
        'nav_contact_url',
        'projects_badge',
        'projects_heading',
        'testimonials_badge',
        'testimonials_heading',
        'testimonials_subheading',
        'contact_badge',
        'contact_heading',
        'contact_subheading',
        'contact_submit_label',
        'contact_submitting_label',
        'contact_name_label',
        'contact_email_label',
        'contact_subject_label',
        'contact_message_label',
        'contact_validation_error',
        'contact_success_message',
        'contact_error_message',
        'contact_network_error',
        'footer_copyright_name',
        'footer_blog_label',
        'footer_github',
        'footer_linkedin',
        'footer_x',
        'footer_tiktok',
        'footer_telegram',
        'footer_instagram',
        'footer_facebook',
        'footer_whatsapp',
        'footer_home_label',
        'footer_github_label',
        'footer_linkedin_label',
        'footer_x_label',
        'footer_tiktok_label',
        'footer_telegram_label',
        'footer_instagram_label',
        'footer_facebook_label',
        'footer_whatsapp_label',
    ];

    public function edit(): View
    {
        $settings = SiteSetting::query()
            ->whereIn('key', self::KEYS)
            ->pluck('value', 'key')
            ->all();

        return view('admin.settings.edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'hero_name' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_cv_url' => ['nullable', 'string', 'max:2048'],
            'hero_cv_file' => ['nullable', 'file', 'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'max:10240'],
            'hero_cta_label' => ['nullable', 'string', 'max:255'],
            'hero_primary_cta_label' => ['nullable', 'string', 'max:255'],
            'hero_availability_text' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string', 'max:2000'],
            'hero_background' => ['nullable', 'string', 'max:2048'],
            'hero_background_alt' => ['nullable', 'string', 'max:255'],
            'hero_background_file' => ['nullable', 'image', 'max:5120'],
            'about_badge' => ['nullable', 'string', 'max:255'],
            'about_heading' => ['nullable', 'string', 'max:255'],
            'about_bio' => ['required', 'string', 'max:5000'],
            'about_profile_image' => ['nullable', 'string', 'max:2048'],
            'about_profile_alt' => ['nullable', 'string', 'max:255'],
            'about_profile_image_file' => ['nullable', 'image', 'max:5120'],
            'skills_badge' => ['nullable', 'string', 'max:255'],
            'skills_heading' => ['nullable', 'string', 'max:255'],
            'skills_subheading' => ['nullable', 'string', 'max:1000'],
            'nav_about_label' => ['nullable', 'string', 'max:255'],
            'nav_skills_label' => ['nullable', 'string', 'max:255'],
            'nav_projects_label' => ['nullable', 'string', 'max:255'],
            'nav_testimonials_label' => ['nullable', 'string', 'max:255'],
            'nav_contact_label' => ['nullable', 'string', 'max:255'],
            'nav_about_url' => ['nullable', 'string', 'max:2048'],
            'nav_skills_url' => ['nullable', 'string', 'max:2048'],
            'nav_projects_url' => ['nullable', 'string', 'max:2048'],
            'nav_testimonials_url' => ['nullable', 'string', 'max:2048'],
            'nav_contact_url' => ['nullable', 'string', 'max:2048'],
            'projects_badge' => ['nullable', 'string', 'max:255'],
            'projects_heading' => ['nullable', 'string', 'max:255'],
            'testimonials_badge' => ['nullable', 'string', 'max:255'],
            'testimonials_heading' => ['nullable', 'string', 'max:255'],
            'testimonials_subheading' => ['nullable', 'string', 'max:1000'],
            'contact_badge' => ['nullable', 'string', 'max:255'],
            'contact_heading' => ['nullable', 'string', 'max:255'],
            'contact_subheading' => ['nullable', 'string', 'max:1000'],
            'contact_submit_label' => ['nullable', 'string', 'max:255'],
            'contact_submitting_label' => ['nullable', 'string', 'max:255'],
            'contact_name_label' => ['nullable', 'string', 'max:255'],
            'contact_email_label' => ['nullable', 'string', 'max:255'],
            'contact_subject_label' => ['nullable', 'string', 'max:255'],
            'contact_message_label' => ['nullable', 'string', 'max:255'],
            'contact_validation_error' => ['nullable', 'string', 'max:255'],
            'contact_success_message' => ['nullable', 'string', 'max:255'],
            'contact_error_message' => ['nullable', 'string', 'max:255'],
            'contact_network_error' => ['nullable', 'string', 'max:255'],
            'footer_copyright_name' => ['nullable', 'string', 'max:255'],
            'footer_blog_label' => ['nullable', 'string', 'max:255'],
            'footer_github' => ['nullable', 'string', 'max:2048'],
            'footer_linkedin' => ['nullable', 'string', 'max:2048'],
            'footer_x' => ['nullable', 'string', 'max:2048'],
            'footer_tiktok' => ['nullable', 'string', 'max:2048'],
            'footer_telegram' => ['nullable', 'string', 'max:2048'],
            'footer_instagram' => ['nullable', 'string', 'max:2048'],
            'footer_facebook' => ['nullable', 'string', 'max:2048'],
            'footer_whatsapp' => ['nullable', 'string', 'max:2048'],
            'footer_home_label' => ['nullable', 'string', 'max:255'],
            'footer_github_label' => ['nullable', 'string', 'max:255'],
            'footer_linkedin_label' => ['nullable', 'string', 'max:255'],
            'footer_x_label' => ['nullable', 'string', 'max:255'],
            'footer_tiktok_label' => ['nullable', 'string', 'max:255'],
            'footer_telegram_label' => ['nullable', 'string', 'max:255'],
            'footer_instagram_label' => ['nullable', 'string', 'max:255'],
            'footer_facebook_label' => ['nullable', 'string', 'max:255'],
            'footer_whatsapp_label' => ['nullable', 'string', 'max:255'],
        ]);

        $current = SiteSetting::query()
            ->whereIn('key', self::KEYS)
            ->pluck('value', 'key')
            ->all();

        $values = [
            'page_title' => trim((string) ($validated['page_title'] ?? '')),
            'meta_description' => trim((string) ($validated['meta_description'] ?? '')),
            'brand_name' => trim((string) ($validated['brand_name'] ?? '')),
            'hero_name' => trim((string) ($validated['hero_name'] ?? '')),
            'hero_title' => trim((string) ($validated['hero_title'] ?? '')),
            'hero_cv_url' => trim((string) ($validated['hero_cv_url'] ?? '')),
            'hero_cta_label' => trim((string) ($validated['hero_cta_label'] ?? '')),
            'hero_primary_cta_label' => trim((string) ($validated['hero_primary_cta_label'] ?? '')),
            'hero_availability_text' => trim((string) ($validated['hero_availability_text'] ?? '')),
            'hero_description' => trim((string) ($validated['hero_description'] ?? '')),
            'hero_background' => trim((string) ($validated['hero_background'] ?? ($current['hero_background'] ?? ''))),
            'hero_background_alt' => trim((string) ($validated['hero_background_alt'] ?? '')),
            'about_badge' => trim((string) ($validated['about_badge'] ?? '')),
            'about_heading' => trim((string) ($validated['about_heading'] ?? '')),
            'about_bio' => trim((string) ($validated['about_bio'] ?? '')),
            'about_profile_image' => trim((string) ($validated['about_profile_image'] ?? ($current['about_profile_image'] ?? ''))),
            'about_profile_alt' => trim((string) ($validated['about_profile_alt'] ?? '')),
            'skills_badge' => trim((string) ($validated['skills_badge'] ?? '')),
            'skills_heading' => trim((string) ($validated['skills_heading'] ?? '')),
            'skills_subheading' => trim((string) ($validated['skills_subheading'] ?? '')),
            'nav_about_label' => trim((string) ($validated['nav_about_label'] ?? '')),
            'nav_skills_label' => trim((string) ($validated['nav_skills_label'] ?? '')),
            'nav_projects_label' => trim((string) ($validated['nav_projects_label'] ?? '')),
            'nav_testimonials_label' => trim((string) ($validated['nav_testimonials_label'] ?? '')),
            'nav_contact_label' => trim((string) ($validated['nav_contact_label'] ?? '')),
            'nav_about_url' => trim((string) ($validated['nav_about_url'] ?? '')),
            'nav_skills_url' => trim((string) ($validated['nav_skills_url'] ?? '')),
            'nav_projects_url' => trim((string) ($validated['nav_projects_url'] ?? '')),
            'nav_testimonials_url' => trim((string) ($validated['nav_testimonials_url'] ?? '')),
            'nav_contact_url' => trim((string) ($validated['nav_contact_url'] ?? '')),
            'projects_badge' => trim((string) ($validated['projects_badge'] ?? '')),
            'projects_heading' => trim((string) ($validated['projects_heading'] ?? '')),
            'testimonials_badge' => trim((string) ($validated['testimonials_badge'] ?? '')),
            'testimonials_heading' => trim((string) ($validated['testimonials_heading'] ?? '')),
            'testimonials_subheading' => trim((string) ($validated['testimonials_subheading'] ?? '')),
            'contact_badge' => trim((string) ($validated['contact_badge'] ?? '')),
            'contact_heading' => trim((string) ($validated['contact_heading'] ?? '')),
            'contact_subheading' => trim((string) ($validated['contact_subheading'] ?? '')),
            'contact_submit_label' => trim((string) ($validated['contact_submit_label'] ?? '')),
            'contact_submitting_label' => trim((string) ($validated['contact_submitting_label'] ?? '')),
            'contact_name_label' => trim((string) ($validated['contact_name_label'] ?? '')),
            'contact_email_label' => trim((string) ($validated['contact_email_label'] ?? '')),
            'contact_subject_label' => trim((string) ($validated['contact_subject_label'] ?? '')),
            'contact_message_label' => trim((string) ($validated['contact_message_label'] ?? '')),
            'contact_validation_error' => trim((string) ($validated['contact_validation_error'] ?? '')),
            'contact_success_message' => trim((string) ($validated['contact_success_message'] ?? '')),
            'contact_error_message' => trim((string) ($validated['contact_error_message'] ?? '')),
            'contact_network_error' => trim((string) ($validated['contact_network_error'] ?? '')),
            'footer_copyright_name' => trim((string) ($validated['footer_copyright_name'] ?? '')),
            'footer_blog_label' => trim((string) ($validated['footer_blog_label'] ?? '')),
            'footer_github' => trim((string) ($validated['footer_github'] ?? '')),
            'footer_linkedin' => trim((string) ($validated['footer_linkedin'] ?? '')),
            'footer_x' => trim((string) ($validated['footer_x'] ?? '')),
            'footer_tiktok' => trim((string) ($validated['footer_tiktok'] ?? '')),
            'footer_telegram' => trim((string) ($validated['footer_telegram'] ?? '')),
            'footer_instagram' => trim((string) ($validated['footer_instagram'] ?? '')),
            'footer_facebook' => trim((string) ($validated['footer_facebook'] ?? '')),
            'footer_whatsapp' => trim((string) ($validated['footer_whatsapp'] ?? '')),
            'footer_home_label' => trim((string) ($validated['footer_home_label'] ?? '')),
            'footer_github_label' => trim((string) ($validated['footer_github_label'] ?? '')),
            'footer_linkedin_label' => trim((string) ($validated['footer_linkedin_label'] ?? '')),
            'footer_x_label' => trim((string) ($validated['footer_x_label'] ?? '')),
            'footer_tiktok_label' => trim((string) ($validated['footer_tiktok_label'] ?? '')),
            'footer_telegram_label' => trim((string) ($validated['footer_telegram_label'] ?? '')),
            'footer_instagram_label' => trim((string) ($validated['footer_instagram_label'] ?? '')),
            'footer_facebook_label' => trim((string) ($validated['footer_facebook_label'] ?? '')),
            'footer_whatsapp_label' => trim((string) ($validated['footer_whatsapp_label'] ?? '')),
        ];

        if ($request->hasFile('hero_cv_file')) {
            SiteSetting::forgetStoredFile($current['hero_cv_url'] ?? null);
            $path = $request->file('hero_cv_file')->store('settings/cv', 'public');
            $values['hero_cv_url'] = url(Storage::url($path));
        }

        if ($request->hasFile('hero_background_file')) {
            SiteSetting::forgetStoredFile($current['hero_background'] ?? null);
            $path = $request->file('hero_background_file')->store('settings', 'public');
            $values['hero_background'] = url(Storage::url($path));
        }

        if ($request->hasFile('about_profile_image_file')) {
            SiteSetting::forgetStoredFile($current['about_profile_image'] ?? null);
            $path = $request->file('about_profile_image_file')->store('settings', 'public');
            $values['about_profile_image'] = url(Storage::url($path));
        }

        $payload = [];
        foreach (self::KEYS as $key) {
            $payload[] = [
                'key' => $key,
                'value' => $values[$key] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SiteSetting::query()->upsert($payload, ['key'], ['value', 'updated_at']);
        SiteSetting::flushResolvedValues();

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Site settings updated successfully.');
    }
}
