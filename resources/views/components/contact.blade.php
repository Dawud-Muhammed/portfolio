<section
    id="contact"
    class="contact-shell mx-auto w-full max-w-7xl px-6 py-20"
    x-data="contactForm()"
    aria-labelledby="contact-heading"
>
    <div class="contact-panel rounded-3xl border p-6 md:p-10">
        <div class="mx-auto mb-8 max-w-2xl text-center">
            <p class="mb-3 inline-flex rounded-full border border-orange-300/45 bg-orange-500/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-orange-200">
                Contact
            </p>
            <h2 id="contact-heading" class="text-3xl font-semibold tracking-tight text-slate-100 md:text-4xl" style="font-family: var(--font-display);">
                Let us build something exceptional.
            </h2>
            <p class="mt-4 text-sm text-slate-300 md:text-base" style="font-family: var(--font-body);">
                Send a message and I will respond as soon as possible.
            </p>
        </div>

        <form class="mx-auto grid w-full max-w-3xl gap-5" @submit.prevent="submitForm" novalidate>
            <input
                type="text"
                name="website"
                x-model="form.website"
                style="display:none"
                tabindex="-1"
                autocomplete="off"
                aria-hidden="true"
            >

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="contact-name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.15em] text-slate-300">Name</label>
                    <input
                        id="contact-name"
                        type="text"
                        x-model.trim="form.name"
                        @input="validateField('name')"
                        class="contact-input w-full rounded-xl border bg-slate-900/50 px-4 py-3 text-sm text-slate-100 outline-none"
                        :class="errors.name ? 'contact-input-error' : ''"
                        autocomplete="name"
                        required
                    >
                    <p class="mt-2 text-xs text-rose-300" x-text="errors.name" x-show="errors.name"></p>
                </div>

                <div>
                    <label for="contact-email" class="mb-2 block text-xs font-semibold uppercase tracking-[0.15em] text-slate-300">Email</label>
                    <input
                        id="contact-email"
                        type="email"
                        x-model.trim="form.email"
                        @input="validateField('email')"
                        class="contact-input w-full rounded-xl border bg-slate-900/50 px-4 py-3 text-sm text-slate-100 outline-none"
                        :class="errors.email ? 'contact-input-error' : ''"
                        autocomplete="email"
                        required
                    >
                    <p class="mt-2 text-xs text-rose-300" x-text="errors.email" x-show="errors.email"></p>
                </div>
            </div>

            <div>
                <label for="contact-subject" class="mb-2 block text-xs font-semibold uppercase tracking-[0.15em] text-slate-300">Subject</label>
                <input
                    id="contact-subject"
                    type="text"
                    x-model.trim="form.subject"
                    @input="validateField('subject')"
                    class="contact-input w-full rounded-xl border bg-slate-900/50 px-4 py-3 text-sm text-slate-100 outline-none"
                    :class="errors.subject ? 'contact-input-error' : ''"
                    autocomplete="off"
                >
                <p class="mt-2 text-xs text-rose-300" x-text="errors.subject" x-show="errors.subject"></p>
            </div>

            <div>
                <label for="contact-message" class="mb-2 block text-xs font-semibold uppercase tracking-[0.15em] text-slate-300">Message</label>
                <textarea
                    id="contact-message"
                    x-model.trim="form.message"
                    @input="validateField('message')"
                    rows="6"
                    class="contact-input w-full rounded-xl border bg-slate-900/50 px-4 py-3 text-sm text-slate-100 outline-none"
                    :class="errors.message ? 'contact-input-error' : ''"
                    required
                ></textarea>
                <p class="mt-2 text-xs text-rose-300" x-text="errors.message" x-show="errors.message"></p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm" :class="status.ok ? 'text-emerald-300' : 'text-rose-300'" x-text="status.message" x-show="status.message"></p>

                <button
                    type="submit"
                    class="contact-submit inline-flex items-center justify-center gap-2 rounded-xl border border-orange-300/45 bg-gradient-to-r from-orange-500 to-orange-400 px-6 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white transition"
                    :disabled="isSubmitting"
                    :aria-busy="isSubmitting"
                >
                    <svg x-show="isSubmitting" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-opacity="0.25" stroke-width="4"></circle>
                        <path d="M22 12a10 10 0 0 1-10 10" stroke="currentColor" stroke-width="4"></path>
                    </svg>
                    <span x-text="isSubmitting ? 'Sending...' : 'Send Message'"></span>
                </button>
            </div>
        </form>
    </div>
</section>
