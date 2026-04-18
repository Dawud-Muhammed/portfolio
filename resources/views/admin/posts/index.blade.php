@extends('layouts.admin')

@section('page_title', 'Admin Blog Posts')

@section('content')
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Blog Posts</h1>
            <p class="mt-2 text-sm text-slate-600">Create and manage article content.</p>
        </div>

        <a href="{{ route('admin.posts.create') }}" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
            New Post
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-premium">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                <tr>
                    <th class="px-5 py-4">Title</th>
                    <th class="px-5 py-4">Slug</th>
                    <th class="px-5 py-4">Published</th>
                    <th class="px-5 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($posts as $post)
                    <tr>
                        <td class="px-5 py-4 font-medium text-slate-900">{{ $post->title }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $post->slug }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $post->published_at?->format('M d, Y') ?? 'Draft' }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?');">
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
                        <td colspan="4" class="px-5 py-8 text-center text-slate-500">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
