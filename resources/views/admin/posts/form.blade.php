@extends('layouts.admin')

@section('page_title', $mode === 'create' ? 'Create Post' : 'Edit Post')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                {{ $mode === 'create' ? 'Create Post' : 'Edit Post' }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">Manage your article metadata and content.</p>
        </div>

        <a href="{{ route('admin.posts.index') }}" class="inline-flex rounded-xl border border-slate-300 bg-white px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
            Back to List
        </a>
    </div>

    <form method="POST" action="{{ $mode === 'create' ? route('admin.posts.store') : route('admin.posts.update', $post) }}" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium md:p-8">
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="title" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('title') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Slug</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $post->slug) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('slug') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="excerpt" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Excerpt</label>
            <textarea id="excerpt" name="excerpt" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="body" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Body</label>
            <textarea id="body" name="body" rows="12" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div class="md:col-span-2">
                <label for="cover_image" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Cover Image URL</label>
                <input id="cover_image" name="cover_image" type="url" value="{{ old('cover_image', $post->cover_image) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('cover_image') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="reading_time_minutes" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Reading Time (min)</label>
                <input id="reading_time_minutes" name="reading_time_minutes" type="number" min="1" max="120" value="{{ old('reading_time_minutes', $post->reading_time_minutes ?: 5) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('reading_time_minutes') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="published_at" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Published At</label>
            <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $post->published_at?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
            @error('published_at') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-6 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            {{ $mode === 'create' ? 'Create Post' : 'Save Changes' }}
        </button>
    </form>
@endsection
