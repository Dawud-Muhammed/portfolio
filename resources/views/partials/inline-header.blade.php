@php
    use App\Models\SiteSetting;
    use Illuminate\Support\Str;

    $isHomeRoute = request()->routeIs('home');
    $brandName = trim($__env->yieldContent('brand_name', SiteSetting::get('brand_name', SiteSetting::get('hero_name', config('app.name', 'Portfolio')))));

    $navigationLinks = collect($navigationLinks ?? [
        ['key' => 'about', 'label' => SiteSetting::get('nav_about_label', 'About'), 'url' => route('home.about')],
        ['key' => 'skills', 'label' => SiteSetting::get('nav_skills_label', 'Skills'), 'url' => route('home.skills')],
        ['key' => 'projects', 'label' => SiteSetting::get('nav_projects_label', 'Projects'), 'url' => route('projects.index')],
        ['key' => 'testimonials', 'label' => SiteSetting::get('nav_testimonials_label', 'Testimonials'), 'url' => route('home.testimonials')],
        ['key' => 'contact', 'label' => SiteSetting::get('nav_contact_label', 'Contact'), 'url' => route('home.contact')],
    ])
        ->map(static function (array $link): array {
            $url = (string) ($link['url'] ?? '');
            $anchor = Str::contains($url, '#') ? (string) Str::afterLast($url, '#') : '';

            return [
                'key' => (string) ($link['key'] ?? ''),
                'label' => (string) ($link['label'] ?? 'Link'),
                'url' => $url,
                'anchor' => $anchor,
            ];
        })
        ->filter(static fn (array $link): bool => $link['key'] !== '' && $link['label'] !== '' && $link['url'] !== '')
        ->values();

    $activeNavKey = request()->routeIs('projects.*')
        ? 'projects'
        : (request()->routeIs('contacts.*') ? 'contact' : 'home');
@endphp

<section
    x-data="inlineHeaderController({
        isHomeRoute: @js($isHomeRoute),
        initialSection: @js($activeNavKey),
        sections: @js($navigationLinks->pluck('key')->all()),
    })"
    x-init="init()"
    class="mx-auto w-full max-w-7xl px-6 pt-8"
>
    <div class="inline-header-shell rounded-2xl border border-slate-300/75 bg-slate-100/80 px-4 py-3 backdrop-blur-sm dark:border-slate-700/75 dark:bg-slate-900/75">
        <div class="flex items-center justify-between gap-3">
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center rounded-md px-1 py-1 text-sm font-semibold text-slate-600 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-100 dark:hover:text-orange-300"
                style="font-family: var(--font-display);"
                aria-label="Go to homepage"
            >
                {{ $brandName }}
            </a>

            <button
                type="button"
                @click="cycleTheme()"
                class="portal-button-secondary"
                :title="themeLabel()"
                :aria-label="themeLabel()"
            >
                <template x-if="selectedTheme === 'light'">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                        <path d="M12 3v2.5M12 18.5V21M4.8 4.8l1.8 1.8M17.4 17.4l1.8 1.8M3 12h2.5M18.5 12H21M4.8 19.2l1.8-1.8M17.4 6.6l1.8-1.8" />
                        <circle cx="12" cy="12" r="4" />
                    </svg>
                </template>
                <template x-if="selectedTheme === 'dark'">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" />
                    </svg>
                </template>
                <span>Theme</span>
            </button>
        </div>

        <nav class="mt-3 flex flex-wrap items-center gap-1" aria-label="Primary navigation">
            @foreach ($navigationLinks as $link)
                @php
                    $navUrl = $isHomeRoute && $link['anchor'] !== ''
                        ? '#'.$link['anchor']
                        : $link['url'];
                @endphp

                <a
                    href="{{ $navUrl }}"
                    @if ($link['anchor'] !== '')
                        @click="navigateTo(@js($link['key']), @js($navUrl), $event)"
                        :aria-current="isActive(@js($link['key'])) ? 'page' : null"
                        :class="isActive(@js($link['key'])) ? 'is-active text-orange-600 dark:text-orange-300' : ''"
                    @endif
                    class="inline-nav-link rounded-md px-3 py-2 text-sm font-medium text-slate-700 transition-colors hover:text-orange-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-400 dark:text-slate-200 dark:hover:text-orange-300"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</section>
