@extends('layouts.admin')

@section('page_title', 'Site Settings')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Site Settings</h1>
        <p class="mt-2 text-sm text-slate-600">Update homepage hero, about section, and footer social links from one place.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium md:p-8">
        @csrf
        @method('PUT')

        <section class="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">Hero</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="hero_name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Name</label>
                    <input id="hero_name" name="hero_name" type="text" value="{{ old('hero_name', $settings['hero_name'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="hero_title" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Title</label>
                    <input id="hero_title" name="hero_title" type="text" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_title') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="hero_cv_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">CV URL</label>
                    <input id="hero_cv_url" name="hero_cv_url" type="url" value="{{ old('hero_cv_url', $settings['hero_cv_url'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_cv_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="hero_background" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Background URL</label>
                    <input id="hero_background" name="hero_background" type="url" value="{{ old('hero_background', $settings['hero_background'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('hero_background') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="hero_background_file" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Hero Background Upload (optional)</label>
                <input id="hero_background_file" name="hero_background_file" type="file" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-lg file:border-0 file:bg-orange-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:uppercase file:tracking-[0.14em] file:text-orange-700">
                @error('hero_background_file') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror

                @if (! empty($settings['hero_background']))
                    <p class="mt-3 text-xs text-slate-500">Current: <a href="{{ $settings['hero_background'] }}" target="_blank" rel="noopener noreferrer" class="text-orange-700 underline">Preview current hero background</a></p>
                @endif
            </div>
        </section>

        <section class="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">About</h2>

            <div>
                <label for="about_bio" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">About Bio</label>
                <textarea id="about_bio" name="about_bio" rows="5" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('about_bio', $settings['about_bio'] ?? '') }}</textarea>
                @error('about_bio') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="about_profile_image" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">About Profile Image URL</label>
                    <input id="about_profile_image" name="about_profile_image" type="url" value="{{ old('about_profile_image', $settings['about_profile_image'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('about_profile_image') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="about_profile_image_file" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">About Profile Upload (optional)</label>
                    <input id="about_profile_image_file" name="about_profile_image_file" type="file" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-lg file:border-0 file:bg-orange-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:uppercase file:tracking-[0.14em] file:text-orange-700">
                    @error('about_profile_image_file') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            @if (! empty($settings['about_profile_image']))
                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Current Profile Image</p>
                    <img src="{{ $settings['about_profile_image'] }}" alt="Current profile image" class="h-28 w-28 rounded-2xl border border-slate-200 object-cover">
                </div>
            @endif
        </section>

        <section class="space-y-5 rounded-2xl border border-slate-200 bg-slate-50/60 p-5">
            <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">Footer</h2>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="footer_github" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">GitHub URL</label>
                    <input id="footer_github" name="footer_github" type="url" value="{{ old('footer_github', $settings['footer_github'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_github') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="footer_linkedin" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">LinkedIn URL</label>
                    <input id="footer_linkedin" name="footer_linkedin" type="url" value="{{ old('footer_linkedin', $settings['footer_linkedin'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_linkedin') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="footer_x" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">X URL</label>
                    <input id="footer_x" name="footer_x" type="url" value="{{ old('footer_x', $settings['footer_x'] ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_x') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="footer_email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Footer Email Link</label>
                    <input id="footer_email" name="footer_email" type="text" value="{{ old('footer_email', $settings['footer_email'] ?? '') }}" placeholder="mailto:hello@example.com" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    @error('footer_email') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </section>

        <button type="submit" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-6 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            Save Settings
        </button>
    </form>
@endsection
