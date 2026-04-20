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

    <div class="overflow-hidden rounded-3xl border border-slate-700 bg-slate-900 shadow-[0_28px_70px_-38px_rgba(15,23,42,0.95)]">
        <div class="grid grid-cols-1 gap-0 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="relative border-b border-slate-800 p-8 lg:border-b-0 lg:border-r lg:p-10">
                <div class="absolute left-0 top-0 h-full w-full bg-[radial-gradient(circle_at_top_right,rgba(249,115,22,0.16),transparent_40%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.04),transparent_36%)]"></div>
                <div class="relative flex h-full flex-col justify-between gap-8">
                    <div>
                        <span class="inline-flex rounded-full border border-orange-300/30 bg-orange-400/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-orange-200">
                            Client Feedback
                        </span>
                        <div class="mt-6 min-h-[220px]">
                            <template x-for="(testimonial, index) in testimonials" :key="testimonial.author + index">
                                <article
                                    x-show="currentIndex === index"
                                    x-transition.opacity.duration.300ms
                                    class="space-y-6"
                                    x-cloak
                                >
                                    <p class="text-2xl leading-relaxed text-slate-100 md:text-3xl" style="font-family: var(--font-display);">
                                        <span class="text-orange-300">“</span><span x-text="testimonial.quote"></span><span class="text-orange-300">”</span>
                                    </p>

                                    <div class="flex items-center gap-4">
                                        <template x-if="testimonial.avatar">
                                            <img
                                                :src="testimonial.avatar"
                                                :alt="`${testimonial.author} avatar`"
                                                class="h-14 w-14 rounded-full border-2 border-orange-300/60 object-cover"
                                                width="56"
                                                height="56"
                                                loading="lazy"
                                                decoding="async"
                                            >
                                        </template>
                                        <template x-if="!testimonial.avatar">
                                            <div class="flex h-14 w-14 items-center justify-center rounded-full border-2 border-orange-300/60 bg-orange-400/10 text-sm font-semibold text-orange-200">
                                                <span x-text="testimonial.author.split(' ').map(part => part[0]).slice(0, 2).join('')"></span>
                                            </div>
                                        </template>

                                        <div>
                                            <p class="text-lg font-semibold text-white" style="font-family: var(--font-display);" x-text="testimonial.author"></p>
                                            <p class="text-sm text-slate-300" x-text="testimonial.role"></p>
                                        </div>
                                    </div>
                                </article>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            @click="previous()"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-700 bg-slate-800 text-slate-100 transition hover:border-orange-300 hover:text-orange-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-300"
                            aria-label="Previous testimonial"
                        >
                            <span aria-hidden="true">←</span>
                        </button>
                        <button
                            type="button"
                            @click="next()"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-700 bg-slate-800 text-slate-100 transition hover:border-orange-300 hover:text-orange-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-300"
                            aria-label="Next testimonial"
                        >
                            <span aria-hidden="true">→</span>
                        </button>
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-400">
                            <span x-text="String(currentIndex + 1).padStart(2, '0')"></span>
                            /
                            <span x-text="String(testimonials.length).padStart(2, '0')"></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-8 lg:p-10">
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                    <template x-for="(testimonial, index) in testimonials" :key="`dot-${testimonial.author}-${index}`">
                        <button
                            type="button"
                            @click="goTo(index)"
                            class="flex items-center gap-3 rounded-2xl border px-4 py-4 text-left transition"
                            :class="currentIndex === index
                                ? 'border-orange-300 bg-orange-400/10 text-white shadow-[0_12px_28px_-20px_rgba(249,115,22,0.75)]'
                                : 'border-slate-700 bg-slate-950/40 text-slate-300 hover:border-orange-300/50 hover:bg-slate-800'"
                            :aria-pressed="currentIndex === index"
                            :aria-label="`Show testimonial from ${testimonial.author}`"
                        >
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-700 bg-slate-800 text-xs font-semibold uppercase tracking-[0.16em] text-orange-200">
                                <span x-text="String(index + 1).padStart(2, '0')"></span>
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold" x-text="testimonial.author"></p>
                                <p class="truncate text-xs text-slate-400" x-text="testimonial.role"></p>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>
