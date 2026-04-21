@extends('layouts.admin')

@section('page_title', 'Admin Testimonials')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Testimonials</h1>
            <p class="mt-2 text-sm text-slate-600">Manage the social proof displayed on the homepage.</p>
        </div>

        <a href="{{ route('admin.testimonials.create') }}" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            New Testimonial
        </a>
    </div>

    <div x-data="{ query: '' }" class="space-y-4">
        <div class="relative max-w-xl">
            <input
                type="search"
                x-model="query"
                placeholder="Search testimonials by author"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 pr-11 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200"
            >

            <button
                type="button"
                x-show="query.length > 0"
                x-cloak
                @click="query = ''"
                class="absolute inset-y-0 right-3 flex items-center text-slate-400 transition hover:text-slate-600"
                aria-label="Clear search"
                title="Clear search"
            >
                <span class="text-xl leading-none">×</span>
            </button>
        </div>

        <div x-data="testimonialReorder()" x-init="init()" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-premium">
            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4 text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">
                Drag rows to reorder
            </div>

            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Sort</th>
                        <th class="px-5 py-4">Quote</th>
                        <th class="px-5 py-4">Author</th>
                        <th class="px-5 py-4">Role</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" data-sort-url="{{ route('admin.testimonials.sort') }}">
                    @forelse ($testimonials as $testimonial)
                        <tr
                            draggable="true"
                            data-testimonial-id="{{ $testimonial->id }}"
                            x-data="{ title: @js(mb_strtolower($testimonial->author ?? $testimonial->name ?? $testimonial->title ?? '')) }"
                            x-show="query === '' || title.includes(query.toLowerCase())"
                            x-cloak
                            class="cursor-move bg-white transition hover:bg-slate-50"
                        >
                            <td class="px-5 py-4 text-slate-500">
                                <span class="inline-flex rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em]">#{{ $testimonial->sort_order }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                <p class="max-w-2xl overflow-hidden" style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                                    {{ $testimonial->quote }}
                                </p>
                            </td>
                            <td class="px-5 py-4 font-medium text-slate-900">{{ $testimonial->author }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $testimonial->role }}</td>
                            <td class="px-5 py-4">
                                @if ($testimonial->is_active)
                                    <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700">Active</span>
                                @else
                                    <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Inactive</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">Edit</a>
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Delete this testimonial?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-rose-700 transition hover:bg-rose-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">No testimonials found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $testimonials->links() }}</div>
@endsection