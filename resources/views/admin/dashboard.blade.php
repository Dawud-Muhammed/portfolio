@extends('layouts.admin')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Dashboard</h1>
        <p class="mt-2 text-sm text-slate-600">Overview of portfolio activity and content.</p>
    </div>

    <section class="grid grid-cols-1 gap-5 md:grid-cols-3">
        <article class="min-w-0 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Projects</p>
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-600">
                    {{ $projectPublishedCount }} / {{ $projectCount }} Published
                </span>
            </div>
            <p class="mt-3 text-4xl font-semibold text-slate-900" style="font-family: var(--font-display);">{{ $projectCount }}</p>
        </article>

        <article class="min-w-0 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Blog Posts</p>
                <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-600">
                    {{ $postPublishedCount }} / {{ $postCount }} Published
                </span>
            </div>
            <p class="mt-3 text-4xl font-semibold text-slate-900" style="font-family: var(--font-display);">{{ $postCount }}</p>
        </article>

        <article class="min-w-0 rounded-3xl border border-orange-200 bg-orange-50 p-6 shadow-premium">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-orange-700">Unread Contacts</p>
            <p class="mt-3 text-4xl font-semibold text-orange-800" style="font-family: var(--font-display);">{{ $unreadContactCount }}</p>
        </article>
    </section>

    <section class="mt-6 grid grid-cols-1 gap-5 xl:grid-cols-3">
        <article class="min-w-0 rounded-3xl border border-slate-200 bg-white p-6 shadow-premium xl:col-span-2">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="text-base font-semibold text-slate-900" style="font-family: var(--font-display);">Recent Contacts</h2>
                <a href="{{ route('admin.contacts.index') }}" class="text-xs font-semibold uppercase tracking-[0.14em] text-orange-600 transition hover:text-orange-700">View Inbox</a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Subject</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($recentContacts as $contact)
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $contact->name }}</td>
                                <td class="max-w-[180px] truncate px-4 py-3 text-slate-600">
                                    <span class="block truncate" title="{{ $contact->subject ?: 'No subject' }}">{{ $contact->subject ?: 'No subject' }}</span>
                                </td>
                                <td class="px-4 py-3 text-slate-600">{{ $contact->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    @if ($contact->read_at)
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-emerald-700">Read</span>
                                    @else
                                        <span class="rounded-full border border-orange-200 bg-orange-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-orange-700">Unread</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-slate-500">No recent contact messages.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-premium">
            <h2 class="text-base font-semibold text-slate-900" style="font-family: var(--font-display);">Quick Actions</h2>
            <p class="mt-2 text-sm text-slate-600">Jump to common admin tasks.</p>

            <div class="mt-5 space-y-3">
                <a href="{{ route('admin.posts.create') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-4 py-3.5 text-xs font-semibold uppercase tracking-[0.14em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                        <path d="m18 2 4 4-13 13-5 1 1-5L18 2z" />
                        <path d="M14 6l4 4" />
                    </svg>
                    <span>New Post</span>
                </a>
                <a href="{{ route('admin.projects.create') }}" class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-700 transition hover:border-orange-300 hover:text-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                        <path d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z" />
                        <path d="M12 10v6M9 13h6" />
                    </svg>
                    <span>New Project</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="flex w-full items-center justify-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-orange-700 transition hover:bg-orange-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="h-4 w-4" aria-hidden="true">
                        <path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z" />
                        <path d="m3 7 9 7 9-7" />
                    </svg>
                    <span>View Inbox</span>
                </a>
            </div>
        </article>
    </section>

    <section class="mt-6 grid grid-cols-1 gap-5 xl:grid-cols-2">
        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-premium">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="text-base font-semibold text-slate-900" style="font-family: var(--font-display);">Recent Posts</h2>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold uppercase tracking-[0.14em] text-orange-600 transition hover:text-orange-700">All Posts</a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($recentPosts as $post)
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $post->title }}</td>
                                <td class="px-4 py-3">
                                    @if ($post->published_at)
                                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-emerald-700">Published</span>
                                    @else
                                        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-xs font-semibold uppercase tracking-[0.14em] text-orange-600 transition hover:text-orange-700">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-slate-500">No recent posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-premium">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="text-base font-semibold text-slate-900" style="font-family: var(--font-display);">Recent Projects</h2>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold uppercase tracking-[0.14em] text-orange-600 transition hover:text-orange-700">All Projects</a>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">
                        <tr>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Featured</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($recentProjects as $project)
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $project->title }}</td>
                                <td class="px-4 py-3">
                                    @if ($project->is_featured)
                                        <span class="rounded-full border border-orange-200 bg-orange-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-orange-700">Featured</span>
                                    @else
                                        <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-500">No</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="text-xs font-semibold uppercase tracking-[0.14em] text-orange-600 transition hover:text-orange-700">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-6 text-center text-slate-500">No recent projects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection
