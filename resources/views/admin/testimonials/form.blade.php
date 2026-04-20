@extends('layouts.admin')

@section('page_title', $mode === 'create' ? 'Create Testimonial' : 'Edit Testimonial')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                {{ $mode === 'create' ? 'Create Testimonial' : 'Edit Testimonial' }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">Update the quote, author, and display state.</p>
        </div>

        <a href="{{ route('admin.testimonials.index') }}" class="inline-flex rounded-xl border border-slate-300 bg-white px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
            Back to List
        </a>
    </div>

    <form method="POST" action="{{ $mode === 'create' ? route('admin.testimonials.store') : route('admin.testimonials.update', $testimonial) }}" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium md:p-8">
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <div>
            <label for="quote" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Quote</label>
            <textarea id="quote" name="quote" rows="6" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('quote', $testimonial->quote) }}</textarea>
            @error('quote') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="author" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Author</label>
                <input id="author" name="author" type="text" value="{{ old('author', $testimonial->author) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('author') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="role" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Role</label>
                <input id="role" name="role" type="text" value="{{ old('role', $testimonial->role) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('role') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div>
                <label for="avatar" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Avatar URL</label>
                <input id="avatar" name="avatar" type="url" value="{{ old('avatar', $testimonial->avatar_url) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
                @error('avatar') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-3 text-sm text-orange-800">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $testimonial->exists ? $testimonial->is_active : true)) class="h-4 w-4 rounded border-orange-300 text-orange-500 focus:ring-orange-300">
                    Active testimonial
                </label>
            </div>
        </div>

        <button type="submit" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-6 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            {{ $mode === 'create' ? 'Create Testimonial' : 'Save Changes' }}
        </button>
    </form>
@endsection