@extends('layouts.admin')

@section('page_title', $mode === 'create' ? 'Create Project' : 'Edit Project')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                {{ $mode === 'create' ? 'Create Project' : 'Edit Project' }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">Fill in the project details below.</p>
        </div>

        <a href="{{ route('admin.projects.index') }}" class="inline-flex rounded-xl border border-slate-300 bg-white px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
            Back to List
        </a>
    </div>

    <form method="POST" action="{{ $mode === 'create' ? route('admin.projects.store') : route('admin.projects.update', $project) }}" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium md:p-8">
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="title" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $project->title) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('title') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Slug</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $project->slug) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('slug') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Description</label>
            <textarea id="description" name="description" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('description', $project->description) }}</textarea>
            @error('description') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="details" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Details</label>
            <textarea id="details" name="details" rows="8" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('details', $project->details) }}</textarea>
            @error('details') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="stack" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Stack (comma separated)</label>
                <input id="stack" name="stack" type="text" value="{{ old('stack', is_array($project->stack) ? implode(', ', $project->stack) : '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('stack') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="published_at" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Published At</label>
                <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $project->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('published_at') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="image" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Image URL</label>
                <input id="image" name="image" type="url" value="{{ old('image', $project->image) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('image') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="github_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">GitHub URL</label>
                <input id="github_url" name="github_url" type="url" value="{{ old('github_url', $project->github_url) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('github_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="demo_url" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Demo URL</label>
                <input id="demo_url" name="demo_url" type="url" value="{{ old('demo_url', $project->demo_url) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('demo_url') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-3 text-sm text-orange-800">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured)) class="h-4 w-4 rounded border-orange-300 text-orange-500 focus:ring-orange-300">
                    Featured project
                </label>
            </div>
        </div>

        <button type="submit" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-6 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            {{ $mode === 'create' ? 'Create Project' : 'Save Changes' }}
        </button>
    </form>
@endsection
