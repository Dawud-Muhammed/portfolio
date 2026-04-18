@php
    $links = $socialLinks ?? [
        ['label' => 'GitHub', 'url' => 'https://github.com/your-username'],
        ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/your-username'],
        ['label' => 'X', 'url' => 'https://x.com/your-username'],
        ['label' => 'Email', 'url' => 'mailto:hello@example.com'],
    ];
@endphp

<footer class="mx-auto mt-16 w-full max-w-7xl border-t border-slate-200/80 px-6 py-8">
    <div class="flex flex-col items-center justify-between gap-4 text-center md:flex-row md:text-left">
        <p class="text-sm text-slate-600" style="font-family: var(--font-body);">
            Copyright {{ date('Y') }} Dawud Muhammed. All rights reserved.
        </p>

        <nav aria-label="Social links" class="flex items-center gap-4 text-sm font-medium text-slate-600" style="font-family: var(--font-body);">
            @foreach ($links as $link)
                <a href="{{ $link['url'] }}" @if (! str_starts_with($link['url'], 'mailto:')) target="_blank" rel="noopener noreferrer" @endif class="transition hover:text-orange-600">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</footer>
