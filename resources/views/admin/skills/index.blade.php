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

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-premium">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                <tr>
                    <th class="px-5 py-4">Name</th>
                    <th class="px-5 py-4">Category</th>
                    <th class="px-5 py-4">Level</th>
                    <th class="px-5 py-4">Years</th>
                    <th class="px-5 py-4">Status</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($skills as $skill)
                    <tr>
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $skill->name }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $skill->category?->label() ?? $skill->category?->value ?? '—' }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $skill->level }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $skill->years }}</td>
                        <td class="px-5 py-4">
                            @if ($skill->published_at)
                                <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700">Published</span>
                            @else
                                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Draft</span>
                            @endif
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
                        <td colspan="6" class="px-5 py-8 text-center text-slate-500">No skills found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $skills->links() }}</div>
@endsection