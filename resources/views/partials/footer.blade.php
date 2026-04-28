@php
    use App\Models\SiteSetting;
    use Illuminate\Support\Str;

    $copyrightName = (string) SiteSetting::get('footer_copyright_name', SiteSetting::get('hero_name', config('app.name', 'Portfolio')));
    $blogLabel = (string) SiteSetting::get('footer_blog_label', 'Blog');

    $links = $socialLinks ?? [
        ['key' => 'home', 'label' => SiteSetting::get('footer_home_label', 'Home'), 'url' => route('home')],
        ['key' => 'github', 'label' => SiteSetting::get('footer_github_label', 'GitHub'), 'url' => SiteSetting::get('footer_github', 'https://github.com/your-username')],
        ['key' => 'linkedin', 'label' => SiteSetting::get('footer_linkedin_label', 'LinkedIn'), 'url' => SiteSetting::get('footer_linkedin', 'https://www.linkedin.com/in/your-username')],
        ['key' => 'x', 'label' => SiteSetting::get('footer_x_label', 'X'), 'url' => SiteSetting::get('footer_x', 'https://x.com/your-username')],
        ['key' => 'tiktok', 'label' => SiteSetting::get('footer_tiktok_label', 'TikTok'), 'url' => SiteSetting::get('footer_tiktok', 'https://www.tiktok.com/@your-username')],
        ['key' => 'telegram', 'label' => SiteSetting::get('footer_telegram_label', 'Telegram'), 'url' => SiteSetting::get('footer_telegram', 'https://t.me/your-username')],
        ['key' => 'instagram', 'label' => SiteSetting::get('footer_instagram_label', 'Instagram'), 'url' => SiteSetting::get('footer_instagram', 'https://www.instagram.com/your-username')],
        ['key' => 'facebook', 'label' => SiteSetting::get('footer_facebook_label', 'Facebook'), 'url' => SiteSetting::get('footer_facebook', 'https://www.facebook.com/your-username')],
        ['key' => 'whatsapp', 'label' => SiteSetting::get('footer_whatsapp_label', 'WhatsApp'), 'url' => SiteSetting::get('footer_whatsapp', 'https://wa.me/2340000000000')],
    ];

    $links = array_values(array_filter($links, static fn (array $link): bool => filled((string) ($link['url'] ?? ''))));
@endphp

<footer class="mx-auto mt-16 w-full max-w-7xl border-t border-slate-200/80 px-6 py-8">
    <div class="flex flex-col items-center justify-between gap-4 text-center md:flex-row md:text-left">
        <p class="text-sm text-slate-600" style="font-family: var(--font-body);">
            Copyright {{ date('Y') }} {{ $copyrightName }}. All rights reserved.
        </p>

        <nav aria-label="Social links" class="mr-14 flex flex-wrap items-center justify-start gap-3 pr-24 text-sm font-medium text-slate-600 sm:mr-16 sm:pr-28 md:mr-24 md:pr-32 lg:pr-36" style="font-family: var(--font-body);">
            @foreach ($links as $link)
                @php
                    $url = (string) ($link['url'] ?? '');
                    $key = (string) ($link['key'] ?? '');
                    $label = (string) ($link['label'] ?? 'Link');
                    $isExternal = Str::startsWith($url, ['http://', 'https://']) && ! Str::startsWith($url, url('/'));
                @endphp

                <a
                    href="{{ $url }}"
                    @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-300/90 bg-white/90 text-slate-600 transition hover:border-orange-300 hover:text-orange-700"
                    aria-label="{{ $label }}"
                    title="{{ $label }}"
                >
                    @if ($key === 'home')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
                            <path d="M3 10.5 12 3l9 7.5" />
                            <path d="M5.5 9.8V21h13V9.8" />
                        </svg>
                    @elseif ($key === 'github')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-1.8c-2.8.6-3.4-1.2-3.4-1.2-.4-1-.9-1.3-.9-1.3-.8-.5.1-.5.1-.5.9.1 1.4.9 1.4.9.8 1.3 2.2 1 2.8.8.1-.6.3-1 .6-1.2-2.2-.2-4.5-1.1-4.5-5a4 4 0 0 1 1.1-2.8c-.2-.2-.5-1.3.1-2.7 0 0 .9-.3 2.9 1.1A9.8 9.8 0 0 1 12 6.8c.9 0 1.8.1 2.6.4 2-1.4 2.9-1.1 2.9-1.1.6 1.4.2 2.5.1 2.7A4 4 0 0 1 18.7 12c0 3.9-2.3 4.7-4.5 5 .4.3.7 1 .7 2v3c0 .3.2.6.7.5A10 10 0 0 0 12 2Z" />
                        </svg>
                    @elseif ($key === 'linkedin')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M6.4 8.8H3.6V20h2.8V8.8Zm-1.4-4A1.6 1.6 0 1 0 5 8a1.6 1.6 0 0 0 0-3.2ZM20.4 13.5c0-3.1-1.7-4.5-4-4.5-1.8 0-2.6 1-3 1.7v-1.5h-2.8V20h2.8v-5.5c0-1.5.3-2.9 2.1-2.9s1.8 1.7 1.8 3V20h2.8v-6.5Z" />
                        </svg>
                    @elseif ($key === 'x')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M18.2 3h2.9l-6.3 7.2L22 21h-5.6l-4.4-5.8L6.9 21H4l6.8-7.8L2 3h5.7L11.7 8 18.2 3Zm-1 16.3h1.6L6.8 4.6H5.1l12.1 14.7Z" />
                        </svg>
                    @elseif ($key === 'tiktok')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M15.9 3.2c.7 1.5 1.8 2.4 3.3 2.8v2.7a7 7 0 0 1-3.2-.8v5.5a5.2 5.2 0 1 1-5.2-5.1c.3 0 .7 0 1 .1V11a2.6 2.6 0 1 0 1.6 2.4V3.2h2.5Z" />
                        </svg>
                    @elseif ($key === 'telegram')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M21.4 4.8 3.9 11.5c-1.2.5-1.2 1.2-.2 1.5l4.5 1.4 1.7 5.2c.2.6.1.9.8.9.5 0 .7-.2 1-.5l2.2-2.1 4.6 3.4c.8.4 1.4.2 1.6-.8l3-14.1c.3-1.1-.4-1.7-1.3-1.3Zm-2.6 3L10.2 15l-.3 3.3-1.3-4.2 10.2-6.3Z" />
                        </svg>
                    @elseif ($key === 'instagram')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
                            <rect x="3.5" y="3.5" width="17" height="17" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17" cy="7" r="1" fill="currentColor" stroke="none" />
                        </svg>
                    @elseif ($key === 'facebook')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M13.6 21v-7h2.4l.4-3h-2.8V9.2c0-.9.2-1.5 1.5-1.5h1.5V5a19 19 0 0 0-2.2-.1c-2.2 0-3.8 1.3-3.8 3.8V11H8v3h2.6v7h3Z" />
                        </svg>
                    @elseif ($key === 'whatsapp')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M12 3.5a8.4 8.4 0 0 0-7.2 12.8L3.5 21l4.9-1.3A8.4 8.4 0 1 0 12 3.5Zm0 15.3c-1.2 0-2.3-.3-3.3-.9l-.2-.1-2.9.8.8-2.8-.1-.2a6.9 6.9 0 1 1 5.7 3.2Zm3.8-5.2c-.2-.1-1.3-.6-1.5-.7-.2-.1-.3-.1-.4.1l-.6.7c-.1.1-.2.1-.4 0-.2-.1-.8-.3-1.5-1-.6-.5-1-1.2-1.1-1.4-.1-.2 0-.3.1-.4l.3-.3.2-.3c.1-.1 0-.2 0-.3l-.4-1.1c-.1-.2-.2-.2-.4-.2h-.3c-.1 0-.3 0-.4.2-.1.2-.6.6-.6 1.5s.6 1.7.7 1.9c.1.1 1.2 2 3 2.8.4.2.8.3 1 .4.4.1.8.1 1.1.1.3 0 1-.4 1.2-.8.1-.4.1-.8.1-.8 0-.1-.1-.2-.3-.3Z" />
                        </svg>
                    @endif

                    <span class="sr-only">{{ $label }}</span>
                </a>
            @endforeach

            <a href="{{ route('blog.index') }}" class="text-xs font-semibold uppercase tracking-[0.12em] transition hover:text-orange-600">
                {{ $blogLabel }}
            </a>
        </nav>
    </div>
</footer>
