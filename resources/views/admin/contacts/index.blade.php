@extends('layouts.admin')

@section('page_title', 'Admin Contacts Inbox')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-slate-900" style="font-family: var(--font-display);">Contacts Inbox</h1>
        <p class="mt-2 text-sm text-slate-600">Review incoming messages from the public contact form.</p>
    </div>

    <div class="space-y-4">
        @forelse ($contacts as $contact)
            <article class="rounded-3xl border {{ $contact->read_at ? 'border-slate-200 bg-white' : 'border-orange-200 bg-orange-50/80' }} p-6 shadow-premium">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900" style="font-family: var(--font-display);">{{ $contact->subject ?: 'No subject' }}</h2>
                        <p class="mt-1 text-sm text-slate-600">From {{ $contact->name }} ({{ $contact->email }})</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.16em] text-slate-500">{{ $contact->created_at->format('M d, Y h:i A') }}</p>
                    </div>

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
                </div>

                <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $contact->message }}</p>
            </article>
        @empty
            <p class="rounded-3xl border border-slate-200 bg-white p-8 text-sm text-slate-600">No contact messages yet.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $contacts->links() }}</div>
@endsection
