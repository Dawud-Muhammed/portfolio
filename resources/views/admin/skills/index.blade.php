@extends('layouts.admin')

@section('page_title', 'Admin Skills')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Skills</h1>
            <p class="mt-2 text-sm text-slate-600">Manage the skills shown across the portfolio.</p>
        </div>

        <a href="{{ route('admin.skills.create') }}" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            New Skill
        </a>
    </div>

    <div x-data="{ query: '' }" class="space-y-4">
        <div class="relative max-w-xl">
            <input
                type="search"
                x-model="query"
                placeholder="Search skills by name"
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

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-premium">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                    <tr>
                        <th class="px-5 py-4">Name</th>
                        <th class="px-5 py-4">Category</th>
                        <th class="px-5 py-4">Level (%)</th>
                        <th class="px-5 py-4">Years</th>
                        <th class="px-5 py-4">Published</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($skillGroups as $group)
                        @php
                            $groupCategory = data_get($group, 'category');
                            $groupSkills = collect(data_get($group, 'skills', []));
                        @endphp

                        <tr class="bg-slate-50/80">
                            <td colspan="6" class="px-5 py-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                                {{ $groupCategory?->label() ?? 'Category' }}
                            </td>
                        </tr>

                        @forelse ($groupSkills as $skill)
                            <tr x-data="{ title: @js(mb_strtolower($skill->name ?? $skill->title ?? '')) }" x-show="query === '' || title.includes(query.toLowerCase())" x-cloak>
                                <td class="px-5 py-4 font-medium text-slate-900">{{ $skill->name }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $skill->category?->label() ?? $skill->category?->value ?? '—' }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $skill->level }}%</td>
                                <td class="px-5 py-4 text-slate-600">{{ $skill->years }}</td>
                                <td class="px-5 py-4">
                                    <div
                                        x-data="{
                                            isPublished: @js((bool) $skill->is_published),
                                            busy: false,
                                            async togglePublish() {
                                                this.busy = true;
                                                const nextState = this.isPublished;

                                                try {
                                                    const response = await fetch('{{ route('admin.skills.toggle', $skill) }}', {
                                                        method: 'PATCH',
                                                        headers: {
                                                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content') ?? '',
                                                            'Accept': 'application/json',
                                                            'Content-Type': 'application/json',
                                                        },
                                                    });

                                                    const data = await response.json();

                                                    if (!response.ok) {
                                                        this.isPublished = !nextState;
                                                        return;
                                                    }

                                                    this.isPublished = Boolean(data.is_published);
                                                } catch (error) {
                                                    this.isPublished = !nextState;
                                                } finally {
                                                    this.busy = false;
                                                }
                                            },
                                        }"
                                        class="flex items-center gap-3"
                                    >
                                        <label class="relative inline-flex cursor-pointer items-center">
                                            <input
                                                type="checkbox"
                                                class="peer sr-only"
                                                x-model="isPublished"
                                                :disabled="busy"
                                                @change="togglePublish()"
                                            >
                                            <span class="h-6 w-11 rounded-full bg-slate-300 transition peer-checked:bg-orange-500 peer-disabled:opacity-60"></span>
                                            <span class="absolute left-0.5 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                                        </label>

                                        <span class="text-xs font-semibold uppercase tracking-[0.14em]" :class="isPublished ? 'text-emerald-700' : 'text-slate-500'" x-text="isPublished ? 'Published' : 'Hidden'"></span>
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.skills.edit', $skill) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" onsubmit="return confirm('Delete this skill?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-rose-700 transition hover:bg-rose-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-6 text-center text-slate-500">No skills in this category.</td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-500">No skills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection