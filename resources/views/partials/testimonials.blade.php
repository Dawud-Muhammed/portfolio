@php
    use App\Models\Testimonial;

    $testimonialPayload = Testimonial::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get()
        ->map(fn (Testimonial $testimonial) => [
            'quote' => $testimonial->quote,
            'author' => $testimonial->author,
            'role' => $testimonial->role,
            'avatar' => $testimonial->avatar_url,
        ])
        ->values();
@endphp

<section
    id="testimonials"
    class="mx-auto w-full max-w-7xl px-6 py-20"
    x-data="testimonialsCarousel(@js($testimonialPayload))"
    x-init="init()"
    aria-labelledby="testimonials-heading"
>
    <div class="mb-10 flex flex-col gap-4 text-center lg:text-left">
        <p class="mx-auto inline-flex rounded-full border border-orange-300/40 bg-orange-400/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-orange-200 lg:mx-0">
            Testimonials
        </p>
        <h2 id="testimonials-heading" class="text-3xl font-semibold tracking-tight text-slate-100 md:text-4xl" style="font-family: var(--font-display);">
            Trusted by thoughtful teams and product leaders.
        </h2>
        <p class="mx-auto max-w-3xl text-sm leading-relaxed text-slate-300 lg:mx-0" style="font-family: var(--font-body);">
            A few words from collaborators and stakeholders who value clear communication, sharp delivery, and polished execution.
        </p>
    </div>

    <div class="relative overflow-hidden rounded-3xl border border-slate-700 bg-slate-900 px-6 py-10 shadow-[0_28px_70px_-38px_rgba(15,23,42,0.95)] sm:px-8 sm:py-12 lg:px-12">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.2),transparent_42%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.04),transparent_36%)]"></div>

        <div class="relative mx-auto flex w-full max-w-3xl flex-col items-center">
            <div class="w-full min-h-[310px] sm:min-h-[280px]">
                <template x-if="!testimonials.length">
                    <article class="rounded-2xl border border-slate-700/80 bg-slate-950/50 px-6 py-10 text-center">
                        <p class="text-lg text-slate-200">No testimonials are available yet.</p>
                    </article>
                </template>

                <template x-for="(testimonial, index) in testimonials" :key="testimonial.author + index">
                    <article
                        x-show="currentIndex === index"
                        x-transition:enter="transition-opacity duration-350"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="rounded-2xl border border-slate-700/80 bg-slate-950/55 px-6 py-8 text-center sm:px-10 sm:py-10"
                    >
                        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center overflow-hidden rounded-full border-2 border-orange-300/70 bg-orange-400/10 text-sm font-semibold uppercase text-orange-200">
                            <template x-if="testimonial.avatar">
                                <img
                                    :src="testimonial.avatar"
                                    :alt="`${testimonial.author} avatar`"
                                    class="h-full w-full object-cover"
                                    width="56"
                                    height="56"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </template>
                            <template x-if="!testimonial.avatar">
                                <span x-text="initialsFor(testimonial.author)"></span>
                            </template>
                        </div>

                        <p class="mx-auto max-w-2xl text-xl leading-relaxed text-slate-100 sm:text-2xl md:text-3xl" style="font-family: var(--font-display);">
                            <span class="text-orange-300" aria-hidden="true">“</span>
                            <span x-text="testimonial.quote"></span>
                            <span class="text-orange-300" aria-hidden="true">”</span>
                        </p>

                        <div class="mt-7 space-y-1">
                            <p class="text-lg font-semibold text-white" style="font-family: var(--font-display);" x-text="testimonial.author"></p>
                            <p class="text-sm text-slate-300" x-text="testimonial.role"></p>
                        </div>
                    </article>
                </template>
            </div>

            <div x-show="testimonials.length > 1" x-cloak class="mt-7 flex flex-col items-center gap-4">
                <div class="flex items-center justify-center gap-3">
                    <button
                        type="button"
                        @click="previous()"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-700 bg-slate-800 text-slate-100 transition hover:border-orange-300 hover:text-orange-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-300"
                        aria-label="Previous testimonial"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4" aria-hidden="true">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>

                    <div class="flex items-center gap-2" role="tablist" aria-label="Testimonial pagination">
                        <template x-for="(testimonial, index) in testimonials" :key="`dot-${testimonial.author}-${index}`">
                            <button
                                type="button"
                                @click="goTo(index)"
                                class="h-2.5 w-2.5 rounded-full border border-orange-300/60 transition"
                                :class="currentIndex === index ? 'bg-orange-300' : 'bg-transparent hover:bg-orange-300/50'"
                                :aria-label="`Show testimonial from ${testimonial.author}`"
                                :aria-pressed="currentIndex === index"
                            ></button>
                        </template>
                    </div>

                    <button
                        type="button"
                        @click="next()"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-700 bg-slate-800 text-slate-100 transition hover:border-orange-300 hover:text-orange-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-300"
                        aria-label="Next testimonial"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
