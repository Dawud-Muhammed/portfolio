@php
    use App\Models\SiteSetting;
    use App\Support\ImageAsset;
    use Illuminate\Support\Facades\Storage;

    $aboutImage = ImageAsset::resolve(
        trim($__env->yieldContent('about_profile_image', SiteSetting::get('about_profile_image', Storage::url('images/photo-1542831371-29b0f74f9713.jpg')))),
        '/storage/images/photo-1542831371-29b0f74f9713.jpg'
    );
    $aboutImageWebp = ImageAsset::webpVariant($aboutImage);
@endphp

<section
    id="about"
    class="mx-auto w-full max-w-7xl px-6 py-20"
    x-data="slideInOnScroll()"
    x-init="observe($el)"
    x-bind:class="isVisible ? 'is-visible' : ''"
    aria-labelledby="about-heading"
>
    <div class="about-panel about-reveal grid grid-cols-1 items-center gap-10 overflow-hidden rounded-3xl border border-cyan-200/40 bg-gradient-to-br from-cyan-50/80 via-white to-emerald-50/70 p-6 shadow-premium dark:border-slate-700/60 dark:bg-slate-900/90 dark:from-slate-900/80 dark:via-slate-900 dark:to-slate-900/70 md:p-10 lg:grid-cols-[minmax(240px,320px),1fr]">
        <div class="relative mx-auto w-full max-w-xs">
            <div aria-hidden="true" class="absolute -inset-3 rounded-[2rem] bg-gradient-to-br from-blue-400/25 to-emerald-400/25 blur-lg"></div>
            <figure class="relative overflow-hidden rounded-[1.75rem] border border-cyan-300/60 bg-white/90 p-3">
                <picture>
                    @if (!empty($aboutImageWebp))
                        <source srcset="{{ $aboutImageWebp }}" type="image/webp">
                    @endif
                    <img
                        src="{{ $aboutImage }}"
                        alt="{{ trim($__env->yieldContent('about_profile_alt', 'Profile portrait of Dawud Muhammed')) }}"
                        class="h-[360px] w-full rounded-2xl object-cover"
                        width="900"
                        height="1200"
                        loading="lazy"
                        decoding="async"
                    >
                    </picture>
                <figcaption class="sr-only">Profile image</figcaption>
            </figure>
        </div>

        <div class="space-y-6 text-center lg:text-left">
            <p class="inline-flex items-center rounded-full border border-cyan-300/50 bg-cyan-500/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-cyan-700 dark:border-cyan-700/50 dark:text-cyan-400">
                About Me
            </p>

            <h2 id="about-heading" class="text-balance text-3xl font-semibold text-slate-900 dark:text-slate-100 md:text-4xl" style="font-family: var(--font-display);">
                Building dependable systems with clean engineering principles.
            </h2>

            <p class="text-base leading-relaxed text-slate-700 dark:text-slate-300 md:text-lg" style="font-family: var(--font-body);">
                {{ trim($__env->yieldContent('about_bio', SiteSetting::get('about_bio', 'I design and ship Laravel products focused on reliability, maintainability, and user trust. From architecture to implementation, I prioritize clear communication, measurable outcomes, and long-term scalability.'))) }}
            </p>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3" aria-label="Core skills">
                @foreach (['Laravel', 'PHP', 'MySQL', 'REST APIs', 'Alpine.js', 'Tailwind CSS'] as $skill)
                    <span class="rounded-xl border border-emerald-300/60 bg-emerald-500/10 px-3 py-2 text-sm font-medium text-emerald-800 dark:border-emerald-700/50 dark:text-emerald-300">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</section>
