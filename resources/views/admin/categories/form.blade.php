@extends('layouts.admin')

@section('page_title', $mode === 'create' ? 'Create Category' : 'Edit Category')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">
                {{ $mode === 'create' ? 'Create Category' : 'Edit Category' }}
            </h1>
            <p class="mt-2 text-sm text-slate-600">Create or update a reusable blog category.</p>
        </div>

        <a href="{{ route('admin.categories.index') }}" class="inline-flex rounded-xl border border-slate-300 bg-white px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
            Back to List
        </a>
    </div>

    <form method="POST" action="{{ $mode === 'create' ? route('admin.categories.store') : route('admin.categories.update', $category) }}" class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium md:p-8">
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <div>
            <label for="name" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
            @error('name') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="slug" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-slate-600">Slug</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $category->slug) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">
            @error('slug') <p class="mt-2 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-6 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            {{ $mode === 'create' ? 'Create Category' : 'Save Changes' }}
        </button>
    </form>
@endsection