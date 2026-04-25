@extends('layouts.admin')

@section('page_title', $mode === 'create' ? 'Create Skill' : 'Edit Skill')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                {{ $mode === 'create' ? 'Create Skill' : 'Edit Skill' }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">Manage a single skill card in the portfolio.</p>
        </div>

        <a href="{{ route('admin.skills.index') }}" class="inline-flex rounded-xl border border-slate-300 bg-white px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
            Back to List
        </a>
    </div>

    <form
        method="POST"
        action="{{ $mode === 'create' ? route('admin.skills.store') : route('admin.skills.update', $skill) }}"
        x-data="{
            skillId: @js(old('skill_id', $skill->skill_id ?? '')),
            slugify(value) {
                return String(value || '')
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            },
            syncSkillId(value) {
                this.skillId = this.slugify(value);
            },
        }"
        class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium md:p-8"
    >
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <input type="hidden" name="skill_id" x-model="skillId">

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $skill->name) }}"
                    @input="syncSkillId($event.target.value)"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200"
                >
                @error('name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="category" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Category</label>
                <select id="category" name="category" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ data_get($category, 'value') }}" @selected(old('category', $skill->category?->value) === data_get($category, 'value'))>{{ data_get($category, 'label') }}</option>
                    @endforeach
                </select>
                @error('category') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="level" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Level</label>
                <div x-data="{ level: Number(@js(old('level', $skill->level ?? 0))) }">
                    <input id="level" name="level" type="range" min="0" max="100" x-model.number="level" class="w-full accent-orange-500">
                    <div class="mt-2 text-xs uppercase tracking-[0.14em] text-slate-500">Current: <span x-text="`${level}%`"></span></div>
                </div>
                @error('level') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="years" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Years</label>
                <input id="years" name="years" type="number" min="0" max="50" value="{{ old('years', $skill->years ?? 0) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('years') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Description</label>
            <textarea id="description" name="description" rows="5" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('description', $skill->description) }}</textarea>
            @error('description') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="published_at" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Published At</label>
            <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $skill->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
            @error('published_at') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-6 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            {{ $mode === 'create' ? 'Create Skill' : 'Save Changes' }}
        </button>
    </form>
@endsection