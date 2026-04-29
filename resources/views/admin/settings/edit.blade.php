@extends('layouts.admin')

@section('page_title', 'Site Settings')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Site Settings</h1>
        <p class="mt-2 text-sm text-slate-600">Manage all homepage copy, media, contact form labels, and footer links.</p>
    </div>

    <nav class="sticky top-0 z-40 mb-8 rounded-3xl border border-slate-200 bg-white/90 p-4 shadow-premium backdrop-blur-sm" aria-label="Site settings sections">
        <div class="flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-[0.14em]">
            <a href="#seo-branding" class="rounded-full border border-slate-200 px-4 py-2 text-slate-600 transition hover:border-orange-300 hover:text-orange-700">SEO and Branding</a>
            <a href="#hero-settings" class="rounded-full border border-slate-200 px-4 py-2 text-slate-600 transition hover:border-orange-300 hover:text-orange-700">Hero</a>
            <a href="#about-settings" class="rounded-full border border-slate-200 px-4 py-2 text-slate-600 transition hover:border-orange-300 hover:text-orange-700">About</a>
            <a href="#section-copy" class="rounded-full border border-slate-200 px-4 py-2 text-slate-600 transition hover:border-orange-300 hover:text-orange-700">Section Copy</a>
            <a href="#contact-settings" class="rounded-full border border-slate-200 px-4 py-2 text-slate-600 transition hover:border-orange-300 hover:text-orange-700">Contact</a>
            <a href="#footer-settings" class="rounded-full border border-slate-200 px-4 py-2 text-slate-600 transition hover:border-orange-300 hover:text-orange-700">Footer</a>
        </div>
    </nav>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium md:p-8">
        @csrf
        @method('PUT')

        <section id="seo-branding" class="scroll-mt-28 space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">SEO and Branding</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="page_title" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Homepage Title</label>
                    <input id="page_title" name="page_title" type="text" value="{{ old('page_title', $settings['page_title'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('page_title') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text becomes the browser title and the main homepage SEO title.</p>
                </div>

                <div>
                    <label for="brand_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Brand Name</label>
                    <input id="brand_name" name="brand_name" type="text" value="{{ old('brand_name', $settings['brand_name'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('brand_name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This name appears in the header and footer branding on the public site.</p>
                </div>
            </div>

            <div>
                <label for="meta_description" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Homepage Meta Description</label>
                <textarea id="meta_description" name="meta_description" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                @error('meta_description') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                <p class="settings-help">Search engines use this description when displaying your homepage preview.</p>
            </div>
        </section>

        <section id="hero-settings" class="scroll-mt-28 space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">Hero</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="hero_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Name</label>
                    <input id="hero_name" name="hero_name" type="text" value="{{ old('hero_name', $settings['hero_name'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This name is shown in the hero heading and the browser schema data.</p>
                </div>

                <div>
                    <label for="hero_title" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Title</label>
                    <input id="hero_title" name="hero_title" type="text" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_title') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This appears directly below your name on the homepage hero section.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="hero_availability_text" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Availability Text</label>
                    <input id="hero_availability_text" name="hero_availability_text" type="text" value="{{ old('hero_availability_text', $settings['hero_availability_text'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_availability_text') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This short line is the status pill at the top of the hero section.</p>
                </div>

                <div>
                    <label for="hero_cv_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">CV URL</label>
                    <input id="hero_cv_url" name="hero_cv_url" type="url" value="{{ old('hero_cv_url', $settings['hero_cv_url'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_cv_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">Paste a direct link to a PDF or use the upload button below to store a new CV file in public storage.</p>

                    <label for="hero_cv_file" class="mt-4 mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Upload CV PDF</label>
                    <input id="hero_cv_file" name="hero_cv_file" type="file" accept="application/pdf,.pdf,.doc,.docx" class="settings-file-input w-full rounded-xl border px-4 py-3 text-sm outline-none">
                    @error('hero_cv_file') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    @if (! empty($settings['hero_cv_url']))
                        <p class="settings-preview">Current CV: <a href="{{ $settings['hero_cv_url'] }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-orange-700 underline">Open current file</a></p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="hero_primary_cta_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Primary CTA Label</label>
                    <input id="hero_primary_cta_label" name="hero_primary_cta_label" type="text" value="{{ old('hero_primary_cta_label', $settings['hero_primary_cta_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_primary_cta_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This is the orange button beside the CV link on the hero section.</p>
                </div>

                <div>
                    <label for="hero_cta_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Secondary CTA Label</label>
                    <input id="hero_cta_label" name="hero_cta_label" type="text" value="{{ old('hero_cta_label', $settings['hero_cta_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_cta_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label appears on the CV download button when a file or URL is available.</p>
                </div>
            </div>

            <div>
                <label for="hero_description" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Description</label>
                <textarea id="hero_description" name="hero_description" rows="4" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                @error('hero_description') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                <p class="settings-help">This paragraph sits under your headline and describes your core value proposition.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="hero_background" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Background URL</label>
                    <input id="hero_background" name="hero_background" type="url" value="{{ old('hero_background', $settings['hero_background'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_background') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This image fills the large hero banner behind your introduction copy.</p>
                </div>

                <div>
                    <label for="hero_background_alt" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Background Alt Text</label>
                    <input id="hero_background_alt" name="hero_background_alt" type="text" value="{{ old('hero_background_alt', $settings['hero_background_alt'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_background_alt') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This alt text is used for accessibility and when the background image cannot load.</p>
                </div>
            </div>

            <div>
                <label for="hero_background_file" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Background Upload (optional)</label>
                <input id="hero_background_file" name="hero_background_file" type="file" accept="image/*" class="settings-file-input w-full rounded-xl border px-4 py-3 text-sm">
                @error('hero_background_file') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                <p class="settings-help">Upload a new image to replace the current hero background without pasting a URL.</p>

                @if (! empty($settings['hero_background']))
                    <p class="settings-preview">Current hero background: <a href="{{ $settings['hero_background'] }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-orange-700 underline">Preview current image</a></p>
                @endif
            </div>
        </section>

        <section id="about-settings" class="scroll-mt-28 space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">About</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="about_badge" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Badge</label>
                    <input id="about_badge" name="about_badge" type="text" value="{{ old('about_badge', $settings['about_badge'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('about_badge') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This small pill appears above the About heading on the homepage.</p>
                </div>

                <div>
                    <label for="about_heading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Heading</label>
                    <input id="about_heading" name="about_heading" type="text" value="{{ old('about_heading', $settings['about_heading'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('about_heading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This is the main About title shown beside your profile image.</p>
                </div>
            </div>

            <div>
                <label for="about_bio" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">About Bio</label>
                <textarea id="about_bio" name="about_bio" rows="5" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('about_bio', $settings['about_bio'] ?? '') }}</textarea>
                @error('about_bio') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                <p class="settings-help">This paragraph becomes the About section body copy on the public homepage.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="about_profile_image" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Profile Image URL</label>
                    <input id="about_profile_image" name="about_profile_image" type="url" value="{{ old('about_profile_image', $settings['about_profile_image'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('about_profile_image') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This image is shown as the portrait in the About section.</p>
                </div>

                <div>
                    <label for="about_profile_alt" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Profile Image Alt Text</label>
                    <input id="about_profile_alt" name="about_profile_alt" type="text" value="{{ old('about_profile_alt', $settings['about_profile_alt'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('about_profile_alt') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">Use a short accessibility label describing the portrait image.</p>
                </div>
            </div>

            <div>
                <label for="about_profile_image_file" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Profile Upload (optional)</label>
                <input id="about_profile_image_file" name="about_profile_image_file" type="file" accept="image/*" class="settings-file-input w-full rounded-xl border px-4 py-3 text-sm">
                @error('about_profile_image_file') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                <p class="settings-help">Upload a new portrait to replace the current About image while keeping the URL field editable.</p>

                @if (! empty($settings['about_profile_image']))
                    <p class="settings-preview">Current profile image: <a href="{{ $settings['about_profile_image'] }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-orange-700 underline">Preview current image</a></p>
                @endif
            </div>
        </section>

        <section id="section-copy" class="scroll-mt-28 space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">Section Copy</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="skills_badge" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Skills Badge</label>
                    <input id="skills_badge" name="skills_badge" type="text" value="{{ old('skills_badge', $settings['skills_badge'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('skills_badge') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This badge appears above the skills section heading.</p>
                </div>

                <div>
                    <label for="skills_heading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Skills Heading</label>
                    <input id="skills_heading" name="skills_heading" type="text" value="{{ old('skills_heading', $settings['skills_heading'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('skills_heading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This line is the main title for the skills showcase on the homepage.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="skills_subheading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Skills Subheading</label>
                    <textarea id="skills_subheading" name="skills_subheading" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('skills_subheading', $settings['skills_subheading'] ?? '') }}</textarea>
                    @error('skills_subheading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This supporting text explains the skills section and its animated counters.</p>
                </div>

                <div>
                    <label for="nav_about_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav About Label</label>
                    <input id="nav_about_label" name="nav_about_label" type="text" value="{{ old('nav_about_label', $settings['nav_about_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_about_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label is used in the top navigation link for the About section.</p>
                </div>

                <div>
                    <label for="nav_about_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav About URL</label>
                    <input id="nav_about_url" name="nav_about_url" type="url" value="{{ old('nav_about_url', $settings['nav_about_url'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_about_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This URL controls where the About navigation item sends visitors.</p>
                </div>

                <div>
                    <label for="nav_skills_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Skills Label</label>
                    <input id="nav_skills_label" name="nav_skills_label" type="text" value="{{ old('nav_skills_label', $settings['nav_skills_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_skills_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label is used in the top navigation link for the Skills section.</p>
                </div>

                <div>
                    <label for="nav_skills_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Skills URL</label>
                    <input id="nav_skills_url" name="nav_skills_url" type="url" value="{{ old('nav_skills_url', $settings['nav_skills_url'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_skills_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This URL controls where the Skills navigation item sends visitors.</p>
                </div>

                <div>
                    <label for="nav_projects_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Projects Label</label>
                    <input id="nav_projects_label" name="nav_projects_label" type="text" value="{{ old('nav_projects_label', $settings['nav_projects_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_projects_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label is used in the top navigation link for the Projects section.</p>
                </div>

                <div>
                    <label for="nav_projects_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Projects URL</label>
                    <input id="nav_projects_url" name="nav_projects_url" type="url" value="{{ old('nav_projects_url', $settings['nav_projects_url'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_projects_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This URL controls where the Projects navigation item sends visitors.</p>
                </div>

                <div>
                    <label for="nav_testimonials_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Testimonials Label</label>
                    <input id="nav_testimonials_label" name="nav_testimonials_label" type="text" value="{{ old('nav_testimonials_label', $settings['nav_testimonials_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_testimonials_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label is used in the top navigation link for the testimonials section.</p>
                </div>

                <div>
                    <label for="nav_testimonials_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Testimonials URL</label>
                    <input id="nav_testimonials_url" name="nav_testimonials_url" type="url" value="{{ old('nav_testimonials_url', $settings['nav_testimonials_url'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_testimonials_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This URL controls where the Testimonials navigation item sends visitors.</p>
                </div>

                <div>
                    <label for="nav_contact_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Contact Label</label>
                    <input id="nav_contact_label" name="nav_contact_label" type="text" value="{{ old('nav_contact_label', $settings['nav_contact_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_contact_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label is used in the top navigation link for the contact section.</p>
                </div>

                <div>
                    <label for="nav_contact_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Nav Contact URL</label>
                    <input id="nav_contact_url" name="nav_contact_url" type="url" value="{{ old('nav_contact_url', $settings['nav_contact_url'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('nav_contact_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This URL controls where the Contact navigation item sends visitors.</p>
                </div>

                <div>
                    <label for="projects_badge" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Projects Badge</label>
                    <input id="projects_badge" name="projects_badge" type="text" value="{{ old('projects_badge', $settings['projects_badge'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('projects_badge') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This badge appears above the projects showcase.</p>
                </div>

                <div>
                    <label for="projects_heading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Projects Heading</label>
                    <input id="projects_heading" name="projects_heading" type="text" value="{{ old('projects_heading', $settings['projects_heading'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('projects_heading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This is the main title for the projects showcase on the homepage.</p>
                </div>

                <div>
                    <label for="testimonials_badge" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Testimonials Badge</label>
                    <input id="testimonials_badge" name="testimonials_badge" type="text" value="{{ old('testimonials_badge', $settings['testimonials_badge'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('testimonials_badge') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This badge appears above the testimonials section.</p>
                </div>

                <div>
                    <label for="testimonials_heading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Testimonials Heading</label>
                    <input id="testimonials_heading" name="testimonials_heading" type="text" value="{{ old('testimonials_heading', $settings['testimonials_heading'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('testimonials_heading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This is the main title for the testimonials section on the homepage.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="testimonials_subheading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Testimonials Subheading</label>
                    <textarea id="testimonials_subheading" name="testimonials_subheading" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('testimonials_subheading', $settings['testimonials_subheading'] ?? '') }}</textarea>
                    @error('testimonials_subheading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This supporting copy explains the testimonial cards shown on the public site.</p>
                </div>
            </div>
        </section>

        <section id="contact-settings" class="scroll-mt-28 space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">Contact Section and Form Messages</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="contact_badge" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Contact Badge</label>
                    <input id="contact_badge" name="contact_badge" type="text" value="{{ old('contact_badge', $settings['contact_badge'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_badge') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This badge appears above the contact form on the homepage.</p>
                </div>

                <div>
                    <label for="contact_heading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Contact Heading</label>
                    <input id="contact_heading" name="contact_heading" type="text" value="{{ old('contact_heading', $settings['contact_heading'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_heading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This is the heading displayed above the contact form fields.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="contact_subheading" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Contact Subheading</label>
                    <textarea id="contact_subheading" name="contact_subheading" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('contact_subheading', $settings['contact_subheading'] ?? '') }}</textarea>
                    @error('contact_subheading') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This supporting text appears under the heading and describes why visitors should reach out.</p>
                </div>

                <div>
                    <label for="contact_submit_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Submit Button Label</label>
                    <input id="contact_submit_label" name="contact_submit_label" type="text" value="{{ old('contact_submit_label', $settings['contact_submit_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_submit_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is shown on the form submit button.</p>
                </div>

                <div>
                    <label for="contact_submitting_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Submitting Label</label>
                    <input id="contact_submitting_label" name="contact_submitting_label" type="text" value="{{ old('contact_submitting_label', $settings['contact_submitting_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_submitting_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text replaces the button label while a message is being sent.</p>
                </div>

                <div>
                    <label for="contact_name_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Name Field Label</label>
                    <input id="contact_name_label" name="contact_name_label" type="text" value="{{ old('contact_name_label', $settings['contact_name_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_name_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label appears above the visitor name field in the contact form.</p>
                </div>

                <div>
                    <label for="contact_email_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Email Field Label</label>
                    <input id="contact_email_label" name="contact_email_label" type="text" value="{{ old('contact_email_label', $settings['contact_email_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_email_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label appears above the visitor email field in the contact form.</p>
                </div>

                <div>
                    <label for="contact_subject_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Subject Field Label</label>
                    <input id="contact_subject_label" name="contact_subject_label" type="text" value="{{ old('contact_subject_label', $settings['contact_subject_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_subject_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label appears above the subject field in the contact form.</p>
                </div>

                <div>
                    <label for="contact_message_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Message Field Label</label>
                    <input id="contact_message_label" name="contact_message_label" type="text" value="{{ old('contact_message_label', $settings['contact_message_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_message_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label appears above the message field in the contact form.</p>
                </div>

                <div>
                    <label for="contact_validation_error" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Validation Error Message</label>
                    <input id="contact_validation_error" name="contact_validation_error" type="text" value="{{ old('contact_validation_error', $settings['contact_validation_error'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_validation_error') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This message shows when a visitor submits incomplete or invalid form data.</p>
                </div>

                <div>
                    <label for="contact_success_message" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Success Message</label>
                    <input id="contact_success_message" name="contact_success_message" type="text" value="{{ old('contact_success_message', $settings['contact_success_message'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_success_message') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This message is shown after the contact form is submitted successfully.</p>
                </div>

                <div>
                    <label for="contact_error_message" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Submission Error Message</label>
                    <input id="contact_error_message" name="contact_error_message" type="text" value="{{ old('contact_error_message', $settings['contact_error_message'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_error_message') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This message is shown if the server rejects the form submission.</p>
                </div>

                <div>
                    <label for="contact_network_error" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Network Error Message</label>
                    <input id="contact_network_error" name="contact_network_error" type="text" value="{{ old('contact_network_error', $settings['contact_network_error'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('contact_network_error') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This message is shown when the request cannot reach the server.</p>
                </div>
            </div>
        </section>

        <section id="footer-settings" class="scroll-mt-28 space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">Footer</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="footer_copyright_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Copyright Name</label>
                    <input id="footer_copyright_name" name="footer_copyright_name" type="text" value="{{ old('footer_copyright_name', $settings['footer_copyright_name'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_copyright_name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This name is shown in the copyright line at the bottom of the site.</p>
                </div>

                <div>
                    <label for="footer_blog_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Blog Link Label</label>
                    <input id="footer_blog_label" name="footer_blog_label" type="text" value="{{ old('footer_blog_label', $settings['footer_blog_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_blog_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label appears on the blog link in the footer navigation.</p>
                </div>

                <div>
                    <label for="footer_home_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Home Icon Label</label>
                    <input id="footer_home_label" name="footer_home_label" type="text" value="{{ old('footer_home_label', $settings['footer_home_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_home_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This label describes the home icon link used in the footer social row.</p>
                </div>

                <div>
                    <label for="footer_github_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">GitHub Icon Label</label>
                    <input id="footer_github_label" name="footer_github_label" type="text" value="{{ old('footer_github_label', $settings['footer_github_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_github_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the GitHub footer link.</p>
                </div>

                <div>
                    <label for="footer_linkedin_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">LinkedIn Icon Label</label>
                    <input id="footer_linkedin_label" name="footer_linkedin_label" type="text" value="{{ old('footer_linkedin_label', $settings['footer_linkedin_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_linkedin_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the LinkedIn footer link.</p>
                </div>

                <div>
                    <label for="footer_x_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">X Icon Label</label>
                    <input id="footer_x_label" name="footer_x_label" type="text" value="{{ old('footer_x_label', $settings['footer_x_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_x_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the X footer link.</p>
                </div>

                <div>
                    <label for="footer_tiktok_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">TikTok Icon Label</label>
                    <input id="footer_tiktok_label" name="footer_tiktok_label" type="text" value="{{ old('footer_tiktok_label', $settings['footer_tiktok_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_tiktok_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the TikTok footer link.</p>
                </div>

                <div>
                    <label for="footer_telegram_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Telegram Icon Label</label>
                    <input id="footer_telegram_label" name="footer_telegram_label" type="text" value="{{ old('footer_telegram_label', $settings['footer_telegram_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_telegram_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the Telegram footer link.</p>
                </div>

                <div>
                    <label for="footer_instagram_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Instagram Icon Label</label>
                    <input id="footer_instagram_label" name="footer_instagram_label" type="text" value="{{ old('footer_instagram_label', $settings['footer_instagram_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_instagram_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the Instagram footer link.</p>
                </div>

                <div>
                    <label for="footer_facebook_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Facebook Icon Label</label>
                    <input id="footer_facebook_label" name="footer_facebook_label" type="text" value="{{ old('footer_facebook_label', $settings['footer_facebook_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_facebook_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the Facebook footer link.</p>
                </div>

                <div>
                    <label for="footer_whatsapp_label" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">WhatsApp Icon Label</label>
                    <input id="footer_whatsapp_label" name="footer_whatsapp_label" type="text" value="{{ old('footer_whatsapp_label', $settings['footer_whatsapp_label'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_whatsapp_label') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This text is announced for the WhatsApp footer link.</p>
                </div>

                <div>
                    <label for="footer_github" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">GitHub URL</label>
                    <input id="footer_github" name="footer_github" type="url" value="{{ old('footer_github', $settings['footer_github'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_github') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should point to your GitHub profile.</p>
                </div>

                <div>
                    <label for="footer_linkedin" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">LinkedIn URL</label>
                    <input id="footer_linkedin" name="footer_linkedin" type="url" value="{{ old('footer_linkedin', $settings['footer_linkedin'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_linkedin') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should point to your LinkedIn profile.</p>
                </div>

                <div>
                    <label for="footer_x" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Twitter (X) URL</label>
                    <input id="footer_x" name="footer_x" type="url" value="{{ old('footer_x', $settings['footer_x'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_x') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should point to your X profile.</p>
                </div>

                <div>
                    <label for="footer_tiktok" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">TikTok URL</label>
                    <input id="footer_tiktok" name="footer_tiktok" type="url" value="{{ old('footer_tiktok', $settings['footer_tiktok'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_tiktok') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should point to your TikTok profile.</p>
                </div>

                <div>
                    <label for="footer_telegram" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Telegram URL</label>
                    <input id="footer_telegram" name="footer_telegram" type="url" value="{{ old('footer_telegram', $settings['footer_telegram'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_telegram') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should point to your Telegram profile.</p>
                </div>

                <div>
                    <label for="footer_instagram" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Instagram URL</label>
                    <input id="footer_instagram" name="footer_instagram" type="url" value="{{ old('footer_instagram', $settings['footer_instagram'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_instagram') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should point to your Instagram profile.</p>
                </div>

                <div>
                    <label for="footer_facebook" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Facebook URL</label>
                    <input id="footer_facebook" name="footer_facebook" type="url" value="{{ old('footer_facebook', $settings['footer_facebook'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_facebook') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should point to your Facebook profile.</p>
                </div>

                <div>
                    <label for="footer_whatsapp" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">WhatsApp URL</label>
                    <input id="footer_whatsapp" name="footer_whatsapp" type="url" value="{{ old('footer_whatsapp', $settings['footer_whatsapp'] ?? '') }}" placeholder="https://wa.me/2340000000000" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_whatsapp') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                    <p class="settings-help">This link appears in the footer social row and should open your WhatsApp contact chat.</p>
                </div>
            </div>
        </section>

        <button type="submit" class="settings-submit">
            Save Settings
        </button>
    </form>
@endsection
