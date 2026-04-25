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
        'hero_name',
        'hero_title',
        'hero_cv_url',
        'hero_background',
        'about_bio',
        'about_profile_image',
        'footer_github',
        'footer_linkedin',
        'footer_x',
        'footer_email',
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
            'hero_name' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_cv_url' => ['nullable', 'string', 'max:2048'],
            'hero_background' => ['nullable', 'string', 'max:2048'],
            'hero_background_file' => ['nullable', 'image', 'max:5120'],
            'about_bio' => ['required', 'string', 'max:5000'],
            'about_profile_image' => ['nullable', 'string', 'max:2048'],
            'about_profile_image_file' => ['nullable', 'image', 'max:5120'],
            'footer_github' => ['nullable', 'string', 'max:2048'],
            'footer_linkedin' => ['nullable', 'string', 'max:2048'],
            'footer_x' => ['nullable', 'string', 'max:2048'],
            'footer_email' => ['nullable', 'string', 'max:2048'],
        ]);

        $current = SiteSetting::query()
            ->whereIn('key', self::KEYS)
            ->pluck('value', 'key')
            ->all();

        $values = [
            'hero_name' => trim((string) ($validated['hero_name'] ?? '')),
            'hero_title' => trim((string) ($validated['hero_title'] ?? '')),
            'hero_cv_url' => trim((string) ($validated['hero_cv_url'] ?? '')),
            'hero_background' => trim((string) ($validated['hero_background'] ?? ($current['hero_background'] ?? ''))),
            'about_bio' => trim((string) ($validated['about_bio'] ?? '')),
            'about_profile_image' => trim((string) ($validated['about_profile_image'] ?? ($current['about_profile_image'] ?? ''))),
            'footer_github' => trim((string) ($validated['footer_github'] ?? '')),
            'footer_linkedin' => trim((string) ($validated['footer_linkedin'] ?? '')),
            'footer_x' => trim((string) ($validated['footer_x'] ?? '')),
            'footer_email' => trim((string) ($validated['footer_email'] ?? '')),
        ];

        if ($request->hasFile('hero_background_file')) {
            $path = $request->file('hero_background_file')->store('settings', 'public');
            $values['hero_background'] = url(Storage::url($path));
        }

        if ($request->hasFile('about_profile_image_file')) {
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
