@extends('layouts.admin')

@section('page_title', 'Admin Contacts Inbox')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Contacts Inbox</h1>
        <p class="mt-2 text-sm text-slate-600">Review incoming messages from the public contact form.</p>
    </div>

    <div class="mb-6 space-y-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-premium">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="flex w-full flex-col gap-3 sm:flex-row lg:max-w-2xl">
                <input type="hidden" name="filter" value="{{ $filter }}">
                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Search by sender name, email, or subject"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200"
                >
                <button type="submit" class="rounded-xl border border-orange-300 bg-orange-50 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-orange-700 transition hover:bg-orange-100">
                    Search
                </button>
            </form>

            <form method="POST" action="{{ route('admin.contacts.read-all', request()->query()) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-xl border border-orange-300 bg-orange-500/10 px-4 py-3 text-xs font-semibold uppercase tracking-[0.14em] text-orange-700 transition hover:bg-orange-500 hover:text-white">
                    Mark all as read
                </button>
            </form>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @php
                $tabs = [
                    'all' => 'All',
                    'unread' => 'Unread',
                    'read' => 'Read',
                ];
            @endphp

            @foreach ($tabs as $key => $label)
                @php
                    $active = $filter === $key;
                    $tabQuery = array_merge(request()->query(), ['filter' => $key]);
                @endphp

                <a
                    href="{{ route('admin.contacts.index', $tabQuery) }}"
                    class="rounded-xl border px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] transition {{ $active ? 'border-orange-500 bg-orange-500 text-white' : 'border-slate-300 bg-white text-slate-700 hover:border-orange-300 hover:text-orange-700' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="space-y-4">
        @forelse ($contacts as $contact)
            @php
                $replySubject = rawurlencode('Re: '.($contact->subject ?: 'Your message'));
                $replyMailto = 'mailto:'.$contact->email.'?subject='.$replySubject.'&body=';
                $replyPanelOpen = old('reply_contact_id') == $contact->id;
            @endphp

            <article
                x-data="{ replyOpen: @js($replyPanelOpen) }"
                class="rounded-3xl border {{ $contact->read_at ? 'border-slate-200 bg-white' : 'border-orange-200 bg-orange-50/80' }} p-6 shadow-premium"
            >
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">{{ $contact->subject ?: 'No subject' }}</h2>
                        <p class="mt-1 text-sm text-slate-600">From {{ $contact->name }} ({{ $contact->email }})</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-500">{{ $contact->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if (! $contact->read_at)
                            <form method="POST" action="{{ route('admin.contacts.read', $contact) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-xl border border-orange-300 bg-orange-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-orange-700 transition hover:bg-orange-500 hover:text-white">
                                    Mark as Read
                                </button>
                            </form>
                        @else
                            <span class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700">Read</span>
                        @endif

                        <a href="{{ $replyMailto }}" class="rounded-xl border border-orange-300 bg-orange-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-orange-700 transition hover:bg-orange-100">
                            Reply
                        </a>
                    </div>
                </div>

                <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $contact->message }}</p>

                <div class="mt-5">
                    <button
                        type="button"
                        @click="replyOpen = !replyOpen"
                        class="inline-flex items-center rounded-xl border border-orange-300 bg-orange-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-orange-700 transition hover:bg-orange-500 hover:text-white"
                    >
                        Reply via Email
                    </button>

                    <form
                        method="POST"
                        action="{{ route('admin.contacts.reply', $contact) }}"
                        x-show="replyOpen"
                        x-cloak
                        class="mt-4 space-y-4 rounded-2xl border border-orange-200 bg-orange-50/80 p-4"
                    >
                        @csrf
                        <input type="hidden" name="reply_contact_id" value="{{ $contact->id }}">
                        <div>
                            <label for="reply_body_{{ $contact->id }}" class="mb-2 block text-xs font-semibold uppercase tracking-[0.14em] text-orange-800">Reply Message</label>
                            <textarea id="reply_body_{{ $contact->id }}" name="reply_body" rows="5" class="w-full rounded-xl border border-orange-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-200">{{ old('reply_contact_id') == $contact->id ? old('reply_body') : '' }}</textarea>
                            @error('reply_body')
                                <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex rounded-xl bg-gradient-to-r from-orange-400 via-orange-500 to-amber-500 px-5 py-3 text-xs font-semibold uppercase tracking-[0.16em] text-white shadow-[0_12px_28px_-16px_rgba(234,88,12,0.65)] transition hover:scale-[1.01]">
                            Send Reply
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <p class="rounded-3xl border border-slate-200 bg-white p-8 text-sm text-slate-600">No contact messages yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $contacts->appends(request()->query())->links() }}</div>
@endsection
